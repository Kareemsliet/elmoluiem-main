<?php

namespace App\Http\Resources;

use App\Http\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */

    public function toArray(Request $request): array
    {
        $user=auth("student")->user();

        return [
            "id" => $this->id,
            "title" => $this->title,
            "hasEnrolled"=>$user?hasEnrolledCourse($user,$this->id):null,
            "description" => $this->description,
            "image" => $this->image?(new ImageService())->imageUrlToBase64("teachers/courses/$this->image"):"",
            "level"=>$this->level->value,
            "price" => $this->price,
            "teacher" => new TeacherResource($this->teacher),
            "sub_category"=>new SubCategoryResource($this->subCategory),
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
        ];
    }
}
