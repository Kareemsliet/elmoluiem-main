<?php

namespace App\Http\Controllers\Api\Teacher;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Main\RatingRequest;
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

        //post

        // Implement the logic to rate a lecture
    }

    public function allReceivedRatings()
    {
        // get

        // Implement the logic to rate a lecture
    }

    public function allGivenRatings()
    {
        //get

        // Implement the logic to rate a lecture
    }

}
