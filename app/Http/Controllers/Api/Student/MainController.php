<?php

namespace App\Http\Controllers\Api\Student;

use App\Http\Controllers\Controller;
use App\Http\Resources\SubjectResource;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public $student;

    public function __construct()
    {
        $this->student = auth("student")->user();
    }
}
