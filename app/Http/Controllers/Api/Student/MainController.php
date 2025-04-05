<?php

namespace App\Http\Controllers\Api\Student;

use App\Http\Controllers\Controller;

class MainController extends Controller
{
    public $student;

    public function __construct()
    {
        $this->student = auth("student")->user();
    }
}
