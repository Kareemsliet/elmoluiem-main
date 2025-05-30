<?php

namespace App\Http\Resources;
use App\Http\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LessonReource extends JsonResource
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
            "id"=>$this->id,
            "price"=>$this->price,
            "title"=>$this->title,
            "hasEnrolled"=>$user?hasEnrolledLesson($user,$this->id):null,
            "logo"=>$this->logo?(new ImageService())->imageUrlToBase64("teachers/lessons/$this->logo"):"",
            "description"=>$this->description,
            "teacher"=> new TeacherResource($this->teacher),
            "created_at"=>$this->created_at,
            "updated_at"=>$this->updated_at,
        ];
    }
}
