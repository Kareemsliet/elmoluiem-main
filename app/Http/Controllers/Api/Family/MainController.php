<?php

namespace App\Http\Controllers\Api\Family;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Main\RatingRequest;
use App\Http\Resources\RatingResource;
use App\Models\Teacher;

class MainController extends Controller
{
    public $family;

    public function __construct()
    {
        $this->family = auth("family")->user();
    }

    public function rateTeacher(RatingRequest $request,$teacher_id){

        $request->validated();

        $teacher=Teacher::find($teacher_id);

        if (!is_numeric($teacher_id) || !$teacher) {
            return failResponse("not found teacher");
        }

        $this->family->teacherRatings()->attach($teacher_id,[
            "rate"=>$request->rate,
            "description"=>$request->description,
        ]);

        return successResponse("success add rate");
    }

    public function studentsRatings(){


        $studentsRatings=[];

        $this->family->students->map(function($item)use($studentsRatings){
            $item->teacherRatingsAboutMe()->orderByPivot("created_at")->get()->map(function($rating)use($studentsRatings){
                return $studentsRatings[]=$rating;
            });
        });

        return successResponse(data:RatingResource::collection($studentsRatings));
    }

    public function allRatings(){
        $ratings=$this->family->teacherRatings()->orderByPivot("created_at","desc")->get();
        
        return successResponse(data:RatingResource::collection($ratings));
    }

}
