<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Musonza\Chat\Facades\ChatFacade as Chat;
use Musonza\Chat\Models\MessageNotification;

class ConversationListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $user = auth("sanctum")->user();

        $participation = $this->conversation->participants->except($user->participation()->first()->id)->first();

        $lastMessage = $this->conversation->messages->last();

        $unread_count = MessageNotification::where([
            ['messageable_id', '=', $user->id],
            ['messageable_type', '=',$user->getMorphClass()],
            ['conversation_id', '=',$this->conversation->id],
            ['is_seen', '=',0],
        ])->count();

        return [
            "conversation_id" => $this->conversation->id,
            "unread_count" => $unread_count,
            "participant" => new ParticipationResource($participation),
            "last_message" => $lastMessage ? new MessageResource($lastMessage) : null,
        ];
    }
}
