<?php

namespace App\Http\Resources;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PayoutResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id"=>$this->id,
            "amount"=>$this->amount,
            "created_at"=>$this->created_at,
            "updated_at"=>$this->updated_at,
            "status"=>$this->status->value,
            "transaction_id"=>$this->transaction_id,
        ];
    }
}
