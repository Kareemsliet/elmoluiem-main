<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Cache;
use Musonza\Chat\Models\Conversation;

class ConversationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $user = auth("sanctum")->user();

        $conversation = Conversation::where("id", '=', $this->id)->first();

        $participation = $this->participants->except($user->participation()->first()->id)->first();

        $lastMessage = $this->messages->last();

        $messages = $conversation->messages()
            ->join('chat_message_notifications', 'chat_message_notifications.message_id', '=', 'chat_messages.id')
            ->where('chat_message_notifications.messageable_type', $user->getMorphClass())
            ->where('chat_message_notifications.messageable_id', $user->id)
            ->orderBy("chat_messages.created_at", "desc")
            ->get();

        $messages =$messages->map(function ($item, $key) use ($messages) {
            if ($item["is_sender"] == 0 ) {
                if (isset($messages[$key + 1])){
                    if($messages[$key+1]["is_sender"]==0){
                        $item['is_after'] = false;
                    }else{
                        $item['is_after'] = true;                        
                    }
                }
            }
            return $item;
        });

        $messages=Cache::remember("chat-conversation:{$conversation->id}.by:{$user->id}",5,function()use($messages){
            return $messages;
        });

        return [
            "id" => $this->id,
            "participant" => new ParticipationResource($participation),
            "last_seen" => $lastMessage ? $lastMessage->created_at : null,
            "created_at" => $this->created_at,
            "messages" => MessageResource::collection($messages),
        ];
    }
}
