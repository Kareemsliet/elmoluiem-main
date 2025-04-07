<?php

namespace App\Http\Resources;

use App\Http\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RatingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $folderPath="";
        
        return [
            "reateable"=>[
                "name"=>$this->name,
                "image"=>$this->profile_image?(new ImageService())->imageUrlToBase64($folderPath.'/'.$this->profile_image):"",
            ],
            "rate"=>$this->pivot->rate,
            "description"=>$this->pivot->description,
            "created_at"=>$this->pivot->created_at,
        ];
    }
}
