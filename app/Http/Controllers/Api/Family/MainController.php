<?php

namespace App\Http\Controllers\Api\Family;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Main\RatingRequest;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public $family;

    public function __construct()
    {
        $this->family = auth("family")->user();
    }

    public function rateTeacher(RatingRequest $request,$teacher){
        
        $request->validated();

        //post

    }

    public function studentsRatings(){
        //get
    }

    public function allRatings(){
        //get
    }
}
