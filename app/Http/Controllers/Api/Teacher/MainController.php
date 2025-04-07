<?php

namespace App\Http\Controllers\Api\Teacher;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Main\RatingRequest;
use App\Http\Resources\RatingResource;
use App\Models\Student;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public $teacher;

    public function __construct()
    {
        $this->teacher = auth("teacher")->user();
    }

    public function rateStudent(RatingRequest $request,$student_id)
    {
        $request->validated();

        $student=Student::find($student_id);

        if (!is_numeric($student_id) || !$student) {
            return failResponse("not found student");
        }

        $this->teacher->studentRatings()->attach($student_id, [
            "rate" => $request->rate,
            "description" => $request->description,
        ]);

        return successResponse("success add rate");
    }

    public function allReceivedRatings()
    {
       $receivesRatings = collect([$this->teacher->studentRatingsAboutMe,$this->teacher->familyRatingsAboutMe])->flatten()->sortByDesc("created_at");

       return successResponse(data:RatingResource::collection($receivesRatings));
    }

    public function allGivenRatings()
    {
        $givenRatings = $this->teacher->studentRatings()->orderByPivot("created_at","desc")->get();

        return successResponse(data:RatingResource::collection($givenRatings));
    }
}
