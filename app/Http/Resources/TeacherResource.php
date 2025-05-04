<?php

namespace App\Http\Resources;

use App\Http\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TeacherResource extends JsonResource
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
            'name'          => $this->name,
            'phone'         => $this->phone,
            'address'       => $this->address,
            "email"         => $this->email,
            "description"   =>$this->description,
            'experince'     => $this->experince,
            'qualification' => $this->qualification,
            "cv"=>$this->cv?(new ImageService())->imageUrlToBase64("teachers/$this->cv"):"",
            "profile_image"=>$this->profile_image?(new ImageService())->imageUrlToBase64("teachers/$this->profile_image"):"",
            "education_level" => new EducationLevelResource($this->educationLevel),
            'course_types'   => $this->course_type,
            "gender"=>$this->gender->value,
            "subjects"=> SubjectResource::collection($this->subjects),
            "courses_count" => $this->courses->count(),
            "lessons_count" => $this->lessons->count(),
            "rating" => (float) collect([$this->studentRatingsAboutMe,$this->familyRatingsAboutMe])->flatten()->avg(fn($item) => $item->pivot->rate)
        ];
    }
}
