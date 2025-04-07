<?php

namespace App\Http\Resources;

use App\Http\Services\ImageService;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RatingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $folderPath = "";

        $reply = [];

        if ($this->getTable() == "familes") {
            $folderPath = "familes";
        } elseif ($this->getTable() == "students") {
            $folderPath = "students";
        } else {
            $folderPath = "teachers";
        }

        if ($this->pivot) {
            if ($this->pivot->student_id) {
                $student = Student::find($this->pivot->student_id);
                $reply["name"] = $student->name;
                $reply["id"]= $student->id;
                $reply["type"]=$student->getTable();
                $reply["image"] = $student->profile_image ? (new ImageService())->imageUrlToBase64('students/' . $student->profile_image) : "";
            } else {
                $teacher = Teacher::find($this->pivot->teacher_id);
                $reply["name"] = $teacher->name;
                $reply["id"]= $teacher->id;
                $reply["type"]=$teacher->getTable();
                $reply["image"] = $teacher->profile_image ? (new ImageService())->imageUrlToBase64('teachers/' . $teacher->profile_image) : "";
            }
        }

        return [
            "rateable" => [
                "id"=>$this->id,
                "type"=>$this->getTable(),
                "name" => $this->name,
                "image" => $this->profile_image ? (new ImageService())->imageUrlToBase64($folderPath . '/' . $this->profile_image) : "",
            ],
            "reply" => $reply,
            "rate" => $this->pivot->rate,
            "description" => $this->pivot->description,
            "created_at" => $this->pivot->created_at,
        ];
    }
}
