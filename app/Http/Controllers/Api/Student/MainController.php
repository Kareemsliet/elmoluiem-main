<?php

namespace App\Http\Controllers\Api\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Main\RatingRequest;
use App\Http\Resources\RatingResource;
use App\Models\Student;
use App\Models\Teacher;

class MainController extends Controller
{
    public $student;

    public function __construct()
    {
        $this->student = auth("student")->user();
    }

    public function rateTeacher(RatingRequest $request, $teacher_id)
    {

        $request->validated();

        $teacher = Teacher::find($teacher_id);

        if (!is_numeric($teacher_id) || !$teacher) {
            return failResponse("not found teacher");
        }

        $this->student->teacherRatings()->attach($teacher_id, [
            "rate" => $request->rate,
            "description" => $request->description,
        ]);

        return successResponse("success add rate");
    }

    public function allGivenRatings()
    {
        $ratings = Teacher::all()->map(function ($item) {
           return  $item->studentRatingsAboutMe()->where("students.id", '=', $this->student->id)->get();
        })
        ->flatten()
        ->sortByDesc(function ($item) {
            $item->pivot->created_at;
        });

        return successResponse(data:RatingResource::collection($ratings));
    }

    public function allReceivedRatings()
    {
       $ratings=$this->student->teacherRatingsAboutMe()->orderByPivot("created_at",'desc')->get();

       return successResponse(data:RatingResource::collection($ratings));
    }
}
