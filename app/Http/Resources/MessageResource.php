<?php

namespace App\Http\Resources;

use App\Http\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Musonza\Chat\Models\MessageNotification;

class MessageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $side = null;

        $data = [];

        $participation = null;

        $read = null;

        $user = auth("sanctum")->user();

        $conversation = $this->conversation;

        if (isset($this->is_sender)) {
            if ($this->is_sender == 1) {

                $side = "left";

                $anotherParticipation = $conversation->participants->except($user->participation()->first()->id)->first();

                $message = MessageNotification::where([
                    ['messageable_id', '=', $anotherParticipation->messageable->id],
                    ['messageable_type', '=', $anotherParticipation->messageable->getMorphClass()],
                    ['conversation_id', '=', $conversation->id],
                    ["message_id", '=', $this->message_id],
                ])->first();

                if ($message) {
                    $isSeen = $message->is_seen == 1 ? true : false;
                    $read = $isSeen;
                }

            } else {
                $side = "right";
                if(isset($this->is_after)){
                    if($this->is_after){
                        $participation = $conversation->participants->except($user->participation()->first()->id)->first();
                    }
                }else{
                    $participation = $conversation->participants->except($user->participation()->first()->id)->first();                    
                }
            }
        }

        if ($this->deleted_at) {
            $data["body"] = "This message has been deleted";
        } else {
            if (isset($this->data["body"])) {
                $data["body"] = $this->data["body"];
            }
            if (isset($this->data["image"])) {
                $data["image"] = [
                    'url' => (new ImageService())->imageUrlToBase64("chat/" . $this->data["image"]["name"]),
                    "size" => (int) ($this->data["image"]["size"] / 1024) . "MB",
                    "type" => $this->data["image"]["extension"],
                ];
            }
        }

        return [
            "id" => $this->id,
            "data" => $data,
            "side" => $side,
            "flagged" => $this->flagged,
            "created_at" => $this->created_at,
            "deleted_at" => $this->deleted_at,
            "read" => $read,
            "sender" => $participation ? new ParticipationResource($participation) : null,
        ];
    }
}
