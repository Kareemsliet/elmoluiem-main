<?php

namespace App\Http\Controllers\Api\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Main\RatingRequest;

class MainController extends Controller
{
    public $student;

    public function __construct()
    {
        $this->student = auth("student")->user();
    }

    public function rateTeacher(RatingRequest $rquest){
        $rquest->validated();
        
        //post
    }

    public function rateLecture(RatingRequest $request){
        $request->validated();
        
        //post
    }

    public function allRatings(){
        // get
    }
}
