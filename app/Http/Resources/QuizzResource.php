<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuizzResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'academic_year' => $this->academic_year,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'time_limit' => $this->time_limit,
            'date' => $this->date,
            "total_score" => $this->questions->sum('score'),
            'subject' => new SubjectResource($this->subject),
            'education_level' => new EducationLevelResource($this->educationLevel),
        ];
    }
}
