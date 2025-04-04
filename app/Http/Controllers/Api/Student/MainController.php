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
    public function toggleFavouriteSubject(Request $request){

        $type="";

        $validation=validator($request->only(["subject_id"]),[
            "subject_id"=>"required|exists:subjects,id"
        ]);

        if($validation->fails()){
            return failResponse($validation->errors()->first());
        }

        $validation->validated();

        $this->student->subjects()->toggle($request->input("subject_id"));

        $existSubject=$this->student->subjects()->where("subject_id",$request->input("subject_id"))->exists();

        if($existSubject){
            $type="add";
        }else{
            $type="remove";
        }

        return successResponse("success $type favourite subject");
    }

    public function favouriteSubjects(){
        
        $subjects=$this->student->subjects()->orderByPivot("created_at","desc")->get();

        return successResponse(data:SubjectResource::collection($subjects));
    }
}
