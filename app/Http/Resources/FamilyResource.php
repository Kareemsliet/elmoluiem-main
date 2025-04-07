<?php

namespace App\Http\Resources;

use App\Http\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FamilyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name'=> $this->name,
            'email'=> $this->email,
            "gender"=>$this->gender->value,
            "description"   =>$this->description,
            'phone' => $this->phone,
            "profile_image"=>$this->profile_image?(new ImageService())->imageUrlToBase64("familes/$this->profile_image"):"",
            "education_level" => new EducationLevelResource($this->educationLevel),
            "students"=> StudentResource::collection($this->students),
        ];
    }
}
