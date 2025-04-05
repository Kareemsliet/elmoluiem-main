<?php

namespace App\Http\Resources;

use App\Http\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $favourite_subjects=$this->subjects()->orderByPivot("created_at","desc")->get();

        return [
            'name'          => $this->name,
            'phone'         => $this->phone,
            'address'       => $this->address,
            "email"         => $this->email,
            "gender"=>$this->gender->value,
            "profile_image"=>$this->profile_image?(new ImageService())->imageUrlToBase64("students/$this->profile_image"):"",
            "description"   =>$this->description,
            "education_level" => new EducationLevelResource($this->educationLevel),
            "favourite_subjects"=>SubjectResource::collection($favourite_subjects),
        ];
    }
}
