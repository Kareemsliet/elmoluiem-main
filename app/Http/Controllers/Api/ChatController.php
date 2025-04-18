<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Resources\ConversationListResource;
use App\Http\Resources\ConversationResource;
use App\Http\Resources\MessageResource;
use App\Http\Services\ImageService;
use App\Models\Family;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Musonza\Chat\Facades\ChatFacade as Chat;
use Musonza\Chat\Models\MessageNotification;
class ChatController extends Controller
{
    protected $user;
    public function __construct()
    {
        $this->user = auth()->user();
    }

    public function conversations(Request $request)
    {
        $search = $request->query("q", "");

        $conversations = Chat::conversations()->setParticipant($this->user)->get()
            ->sortByDesc(function ($item) {
                return $item->conversation->messages->last()?->created_at;
            })
            ->filter(function ($item) {
                $participation = $item->conversation->participants->except($this->user->participation()->first()->id)
                    ->filter(function ($item) {
                        return !($item->messageable->id == $this->user->id && $item->messageable->getTable() === $this->user->getTable());
                    })->first();
                return $participation ? true : false;
            })
            ->filter(function ($item) {
                $hiddenConversation = $this->user->hiddenConversations()->where("chat_conversations.id", '=', $item->conversation->id)->first();
                return $hiddenConversation ? false : true;
            })
            ->filter(function ($item) use ($search) {
                $participation = $item->conversation->participants->except($this->user->participation()->first()->id)->first()->messageable->whereAny(['name', 'phone'], 'like', "%$search%")->first();
                return $participation ? true : false;
            });

        return successResponse(data: ConversationListResource::collection($conversations));
    }

    public function conversation($id)
    {
        $conversation = Chat::conversations()->setParticipant($this->user)->getById($id);

        if (!$conversation) {
            return failResponse("not found conversation");
        }

        DB::transaction(function () use ($conversation) {
            Chat::conversation($conversation)->setParticipant($this->user)->readAll();
        });

        return successResponse(data: new ConversationResource($conversation));
    }

    public function deleteMessage(Request $request, $conversation_id, $message_id)
    {
        $conversation = Chat::conversations()->setParticipant($this->user)->getById($conversation_id);

        if (!$conversation) {
            return failResponse("not found conversation");
        }

        $message = Chat::conversation($conversation)->setParticipant($this->user)->getMessages()
            ->where("id", "=", $message_id)
            ->whereNull("deleted_at")
            ->first();

        if (!$message) {
            return failResponse("not found message");
        }

        $validation = validator($request->only("type"), [
            "type" => $request->when(function () use ($message) {
                return $message->is_sender == 1 ? true : false;
            }, function () {
                return "string|required|in:0,1";
            }, function () {
                return "string|required|in:0";
            })
        ]);

        if ($validation->fails()) {
            return failResponse($validation->errors()->first());
        }

        $validation->validated();

        $messageNotification = MessageNotification::where("id", '=', $message->id)->first();

        if (isset($message->data["image"]) && $request->input("type") == 1) {
            (new ImageService())->destroyImage($message->data["image"]["name"], "chat");
        }

        if ($request->input("type")  == 1) {
            $messageNotification->message->messageNotifications->map(function ($item) {
                if ($item) {
                    Chat::message($item->message)->setParticipant($item->messageable)->delete();
                }
            });
        } else {
            DB::transaction(function () use ($messageNotification) {
                Chat::message($messageNotification->message)->setParticipant($this->user)->delete();
            });
        }

        return successResponse("message deleted");
    }

    public function toggleFlagMessage($conversation_id, $message_id)
    {
        $conversation = Chat::conversations()->setParticipant($this->user)->getById($conversation_id);

        $flagged = false;

        if (!$conversation) {
            return failResponse("not found conversation");
        }

        $message = Chat::conversation($conversation)->setParticipant($this->user)->getMessages()
            ->where("id", "=", $message_id)
            ->whereNull("deleted_at")
            ->first();

        if (!$message) {
            return failResponse("not found message");
        }

        $messageNotification = MessageNotification::where("id", '=', $message->id)->first();

        if ($messageNotification->flagged) {
            $flagged = "remove";
        } else {
            $flagged = "add";
        }

        DB::transaction(function () use ($messageNotification, $flagged) {
            $messageNotification->update([
                "flagged" => $flagged == "add" ? 1 : 0,
            ]);
        });

        return successResponse("message $flagged flagged");
    }
    public function clearConversation($conversation_id)
    {
        $conversation = Chat::conversations()->setParticipant($this->user)->getById($conversation_id);

        if (!$conversation) {
            return failResponse("not found conversation");
        }

        Chat::conversation($conversation)->setParticipant($this->user)->clear();

        return successResponse("conversation cleared");
    }

    public function flaggedMessages()
    {
        $messages = MessageNotification::whereHasMorph("messageable", [get_class($this->user)], function ($query) {
            $query->where("messageable_id", "=", $this->user->id);
        })
            ->where("flagged", "=", 1)
            ->orderBy("created_at", "desc")
            ->get()
            ->transform(function ($item) {
                $item["data"] = $item->message->data;
                return $item;
            });

        return successResponse(data: MessageResource::collection($messages));
    }

    public function createMessage(Request $request, $conversation_id)
    {
        $conversation = Chat::conversations()->setParticipant($this->user)->getById($conversation_id);

        if (!$conversation) {
            return failResponse("not found conversation");
        }

        $validation = validator()->make($request->only(["body", 'image']), [
            "body" => $request->whenMissing("image", function () {
                return "required|string|max:1000";
            }, function () {
                return "nullable|string|max:1000";
            }),
            "image" => $request->whenMissing("body", function () {
                return "required|image|mimes:jpeg,png,jpg,gif,svg|max:2048";
            }, function () {
                return "nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048";
            }),
        ]);

        if ($validation->fails()) {
            return failResponse($validation->errors()->first());
        }

        $validation->validated();

        $participation = $conversation->participants->except($this->user->participation()->first()->id)->first()->messageable;

        $messageData = [
            "body" => $request->input("body"),
        ];

        if ($request->file("image")) {
            $image = (new ImageService())->uploadImage($request->file("image"), "chat");
            $messageData["image"] = [
                "name" => $image,
                "size" => $request->file("image")->getSize(),
                "extension" => $request->file("image")->getClientOriginalExtension(),
            ];
        }

        Chat::message("attachment")
            ->data($messageData)
            ->from($this->user)
            ->to($conversation)
            ->send();

        $existHiddenConversation = $this->user->hiddenConversations()
            ->where("chat_conversations.id", '=', $conversation->id)->first();

        if ($existHiddenConversation) {
            $this->user->hiddenConversations()->detach($conversation->id);
        }

        $participantHiddenConversation = $participation->hiddenConversations()
            ->where("chat_conversations.id", '=', $conversation->id)->first();

        if ($participantHiddenConversation) {
            $participation->hiddenConversations()->detach($conversation->id);
        }

        return successResponse("message sent");
    }

    public function createConversation(Request $request, $user_id)
    {
        $newFriend = null;

        $role = $request->header("role", "");

        if (!in_array($role, ["students", "teachers", "familes"])) {
            return failResponse("role must be student, teacher or family");
        }

        if ($role === "familes") {
            $newFriend = Family::where("id", '=', $user_id)->first();
        } elseif ($role === "students") {
            $newFriend = Student::where("id", '=', $user_id)->first();
        } else {
            $newFriend = Teacher::where("id", '=', $user_id)->first();
        }

        if (!$newFriend || ($this->user->getTable() == $role && $this->user->id == $newFriend->id)) {
            return failResponse("not found user");
        }

        $existingConversation = Chat::conversations()->setParticipant($this->user)->get()->map(function ($item) {
            $participation = $item->conversation->participants->except($this->user->participation()->first()->id)->first();
            return $participation->messageable;
        })
            ->filter(function ($item) use ($newFriend, $role) {
                return $item->id == $newFriend->id && $item->getTable() === $role;
            })
            ->flatten()
            ->first();

        if ($existingConversation) {
            return failResponse("conversation already exists");
        }

        $newConversation = Chat::createConversation([$this->user, $newFriend])->makePrivate();

        return successResponse("succes add new conversation", new ConversationResource($newConversation));
    }
    public function hideConversation(Request $request, $conversation_id)
    {
        $conversation = Chat::conversations()->setParticipant($this->user)->getById($conversation_id);

        if (!$conversation) {
            return failResponse("not found conversation");
        }

        $existHiddenConversation = $this->user->hiddenConversations()
            ->where("chat_conversations.id", '=', $conversation->id)->first();

        if ($existHiddenConversation) {
            return failResponse("conversation exist hidden");
        }

        Chat::conversation($conversation)->setParticipant($this->user)->clear();

        $this->user->hiddenConversations()->attach($conversation->id);

        return successResponse("success hide conversation");
    }
}
