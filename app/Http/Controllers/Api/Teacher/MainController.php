<?php

namespace App\Http\Controllers\Api\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public $teacher;
    
    public function __construct()
    {
        $this->teacher = auth("teacher")->user();
    }

    public function rateStudent()
    {
        // Implement the logic to rate a lecture
    }

    public function allRatings()
    {
        // Implement the logic to rate a lecture
    }
}
