<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Resources\ContentLecturesReource;
use App\Http\Resources\ContentReource;
use App\Http\Resources\CourseResource;
use App\Models\Course;
use Illuminate\Http\Request;

class CoursesController extends Controller
{
    public function courseDetails($course_id){
        $course = Course::find($course_id);

        if (!$course || !is_numeric($course_id)) {
            return failResponse("not found course");
        }
        
        return successResponse(data:new CourseResource($course));
    }
    public function allCourses(Request $request)
    {
        $search = $request->query("q", "");

        $courses = Course::where("title", 'like', "%$search%")->orderByDesc("created_at")->offset(0)->limit(12)->get();

        return successResponse(data:CourseResource::collection($courses));
    }
    public function contents($course_id)
    {
        $course = Course::find($course_id);

        if (!$course || !is_numeric($course_id)) {
            return failResponse("not found course");
        }

        $contents=$course->contents()->orderByDesc("created_at")->get();

        return successResponse(data:ContentReource::collection($contents));
    }
    public function lectures($course_id,$content_id)
    {
        $course = Course::find($course_id);

        if (!$course || !is_numeric($course_id)) {
            return failResponse("not found course");
        }

        $content=$course->contents()->find($content_id);

        if (!$content || !is_numeric($content_id)) {
            return failResponse("not found content");
        }

        $lectures=$content->lectures()->orderByDesc("created_at")->get();

        return successResponse(data:ContentLecturesReource::collection($lectures));
    }
}
