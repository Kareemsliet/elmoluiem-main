<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
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
        ->cursor();

        return [
            "id" => $this->id,
            "participant" => new ParticipationResource($participation),
            "last_seen" => $lastMessage ? $lastMessage->created_at : null,
            "created_at" => $this->created_at,
            "messages" => MessageResource::collection($messages),
        ];
    }
}
