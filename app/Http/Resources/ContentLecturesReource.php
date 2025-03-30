<?php

namespace App\Http\Resources;
use App\Http\Services\ImageService;
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
        return [
            "id"=>$this->id,
            "title"=>$this->title,
            "description"=>$this->description,
            "video"=>(new ImageService())->imageUrlToBase64("teachers/lessons/lectures/$this->video"),
            "deuration"=>$this->deuration,
            "contents"=>new ContentReource($this->content),
        ];
    }
}
