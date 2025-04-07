<?php

namespace App\Http\Controllers\Api\Family;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Main\RatingRequest;
use App\Http\Resources\RatingResource;
use App\Models\Teacher;

class MainController extends Controller
{
    public $family;

    public function __construct()
    {
        $this->family = auth("family")->user();
    }

    public function rateTeacher(RatingRequest $request, $teacher_id)
    {
        $request->validated();

        $teacher = Teacher::find($teacher_id);

        if (!is_numeric($teacher_id) || !$teacher) {
            return failResponse("not found teacher");
        }

        $this->family->teacherRatings()->attach($teacher_id, [
            "rate" => $request->rate,
            "description" => $request->description,
        ]);

        return successResponse("success add rate");
    }
    public function studentsRatings()
    {
        $students=$this->family->students->pluck("id")->toArray();

        $ratings=Teacher::all()->map(function($item)use($students){
            return $item->studentRatings()->whereIn("students.id",$students)->get();
        })->flatten()
        ->sortByDesc(function($item){
            $item->pivot->created_at;
        });

        return successResponse(data: RatingResource::collection($ratings));
    }
    public function allRatings()
    {
        $ratings=Teacher::all()->map(function($item){
            return $item->familyRatingsAboutMe()->where("familes.id",$this->family->id)->get();
        })->flatten()
        ->sortByDesc(function($item){
            $item->pivot->created_at;
        });

        return successResponse(data: RatingResource::collection($ratings));
    }
}
