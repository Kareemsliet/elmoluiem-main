<?php

namespace App\Http\Controllers\Api\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Main\RatingRequest;
use App\Models\Teacher;
use App\Models\Rating;
class MainController extends Controller
{
    public $student;

    public function __construct()
    {
        $this->student = auth("student")->user();
    }

    public function rateTeacher(RatingRequest $rquest,$teacher_id){
        $rquest->validated();
    

        //post



$teacher = Teacher::find($teacher_id);
if (!$teacher) {
    
    return failResponse("Teacher not found");
}


$rating = new Rating();
$rating->student_id = $this->student->id;
$rating->teacher_id = $teacher_id;
$rating->rating = $request->rate; 
$rating->description = $request->description; 
$rating->save();


return successResponse("Rating submitted successfully");


    }

    public function allGivenRatings(RatingRequest $request){
        $request->validated();
        
        //get
        $ratings = Rating::where('student_id', $this->student->id)->get();

        
        return successResponse("All given ratings", $ratings);
    }

    public function allReceivedRatings(){
        // get
        $ratings = Rating::where('student_id', $this->student->id)->get();

        
        return successResponse("All received ratings", $ratings);

    }
}
