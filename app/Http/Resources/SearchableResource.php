<?php

namespace App\Http\Resources;

use App\Models\Family;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SearchableResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $table = "";

        $details = null;

        if ($this->getTable() == "familes") {
            $table = "familes";
            $details = new FamilyResource(Family::find($this->id));
        } else if ($this->getTable() == "students") {
            $table = "students";
            $details = new StudentResource(Student::find($this->id));
        } else {
            $table = "teachers";
            $details = new TeacherResource(Teacher::find($this->id));
        }

        return [
            "id" => $this->id,
            "type"=>$table,
            "details"=>$details,
        ];
    }
}
