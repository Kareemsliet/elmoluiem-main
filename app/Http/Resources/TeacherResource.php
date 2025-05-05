<?php

namespace App\Http\Resources;

use App\Http\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Musonza\Chat\Facades\ChatFacade as Chat;

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
        $user=auth("sanctum")->user();

        $conversation=null;

        if($user){
            if(!($user->id==$this->id && $user->getTable()=="teachers")){
                
                $existingParticipation = Chat::conversations()->setParticipant($this->getModel())->get()->map(function ($item) {
                    $participation = $item->conversation->participants->except($this->participation()->first()->id)->first();
                    return $participation->messageable;
                })
                ->filter(function ($item) use ($user) {
                    return $item->id == $user->id && $item->getTable() === $user->getTable();
                })
                ->flatten()
                ->first();

                if($existingParticipation){
                    $conversation=Chat::conversations()->setParticipant($existingParticipation)->get()->map(function ($item) {
                        $particiption = $item->conversation->participants()->where("messageable_type",'=',get_class($this->getModel()))
                        ->where("messageable_id",'=',$this->id)
                        ->first();
                        return $particiption->conversation_id;
                    })->flatten()->first();
                }
            }
        }

        return [
            "id"           => $this->id,
            'name'          => $this->name,
            'phone'         => $this->phone,
            'address'       => $this->address,
            "email"         => $this->email,
            "conversation"  => $conversation,
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
