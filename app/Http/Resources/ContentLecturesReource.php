<?php

namespace App\Http\Resources;
use App\Http\Services\ViemoService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContentLecturesReource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $user=auth("student")->user();

        $hasEnrolled=false;

        $contentable=$this->content->contentable;

        if($user){
            if($contentable->getTable()=="lessons"){
                $hasEnrolled=hasEnrolledLesson($user,$contentable->id);
            }else{
                $hasEnrolled=hasEnrolledCourse($user,$contentable->id);
            }
        }

        return [
            "id"=>$this->id,
            "title"=>$this->title,
            "description"=>$this->description,
            "duration"=>$this->deuration,
            "videoUrl"=>$user?($hasEnrolled?(new ViemoService())->getVideoUrl($this->video):null):null,
        ];
    }
}
