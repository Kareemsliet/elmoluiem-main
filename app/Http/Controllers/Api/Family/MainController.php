<?php

namespace App\Http\Controllers\Api\Family;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public $family;

    public function __construct()
    {
        $this->family = auth("family")->user();
    }

    public function rateTeacher(){

    }

    public function studentsRatings(){

    }

    public function allRatings(){

    }
}
