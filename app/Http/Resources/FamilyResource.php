<?php

namespace App\Http\Resources;

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
            'phone' => $this->phone,
            "education_level" => new EducationLevelResource($this->educationLevel),
            "students"=> StudentResource::collection($this->students),
        ];
    }
}
