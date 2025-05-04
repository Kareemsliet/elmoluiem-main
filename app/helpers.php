<?php

use App\Models\Course;

function failResponse($message =null, $data = null)
{
    $response = [
        'status' => false,
        "message" => $message,
        "data" => $data,
    ];
    return response()->json($response,422);
}

function successResponse($message = null, $data = null){
    $response = [
        'status' => true,
        "message" => $message,
        "data" => $data,
    ];
    return response()->json($response,200);
}

function unAuthorize($message="un authorize"){
    $response = [
        'status' => false,
        "message" => $message,
    ];
    return response()->json($response,403);
}

function hasEnrolledCourse($user,$courseId){
    return $user->enrollingCourses()->where("courses.id",'=',$courseId)->exists();
}

function hasEnrolledLesson($user,$lessonId){
    return $user->enrollingLessons()->where("lessons.id",'=',$lessonId)->exists();
}

