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

        if($this->rateable_type=="App\Models\Teacher"){
            $folderPath="teachers";
        }elseif($this->rateable_type=="App\Models\Student"){
            $folderPath="students";
        }else{
            $folderPath="familes";
        }
        
        return [
            "reateable"=>[
                "name"=>$this->rateable->name,
                "image"=>$this->rateable->profile_image?(new ImageService())->imageUrlToBase64($folderPath.'/'.$this->rateable->profile_image):"",
            ],
            "rate"=>$this->rate,
            "description"=>$this->description,
            "created_at"=>$this->created_at,
        ];
    }
}
