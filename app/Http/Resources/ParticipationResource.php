<?php

namespace App\Http\Resources;

use App\Http\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

class ParticipationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $table="";

        if($this->messageable_type=="App\Models\Student"){
            $table="students";
        }else if($this->messageable_type=="App\Models\Teacher"){
            $table="teachers";
        }else if($this->messageable_type=="App\Models\Family"){
            $table="familes";
        }

        return [
            "id"=>$this->messageable->id,
            "name"=>$this->messageable->name,
            "role"=>$table,
            "phone"=>$this->messageable->phone,
            "profile_image"=>$this->messageable->profile_image?(new ImageService())->imageUrlToBase64($table."/".$this->messageable->profile_image):"",
        ];
    }
}
