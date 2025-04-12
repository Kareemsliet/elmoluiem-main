<?php

namespace App\Http\Controllers\Api\Teacher\Courses;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Teacher\Lessons\ContentRequest;
use App\Http\Resources\ContentReource;
use App\Models\Course;

class ContentsController extends Controller
{
    public function index($course_id)
    {
        $course = Course::find($course_id);

        if (!is_numeric($course_id) || !$course) {
            return failResponse("not found course");
        }

        $contents = $course->contents()->orderByDesc("created_at")->get();
        
        return successResponse(data:ContentReource::collection($contents));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ContentRequest $request,$course_id)
    {
        $course = Course::find($course_id);

        if (!is_numeric($course_id) || !$course) {
            return failResponse("not found course");
        }

        $request->validated();

        $data = $request->only(["title", "description"]);

        $content = $course->contents()->create($data);

        return successResponse("success add content", new ContentReource($content));
    }

    /**
     * Display the specified resource.
     */
    public function show($course_id,$id)
    {
        $course = Course::find($course_id);

        if (!is_numeric($course_id) || !$course) {
            return failResponse("not found course");
        }

        $content=$course->contents()->find($id);

        if(!is_numeric($id) || !$content) {
            return failResponse("not found content");
        }

        return successResponse(data: new ContentReource($content));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ContentRequest $request,$course_id,$id)
    {
        $request->validated();

        $course = Course::find($course_id);

        if (!is_numeric($course_id) || !$course) {
            return failResponse("not found course");
        }

        $content=$course->contents()->find($id);

        if(!is_numeric($id) || !$content) {
            return failResponse("not found content");
        }

        $data = $request->only(["title", "description"]);

        $content->update($data);

        return successResponse("success update content", new ContentReource($content));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($course_id,$id)
    {
        $course = Course::find($course_id);

        if (!is_numeric($course_id) || !$course) {
            return failResponse("not found course");
        }

        $content=$course->contents()->find($id);

        if(!is_numeric($id) || !$content) {
            return failResponse("not found content");
        }

        $content->delete();

        return successResponse("success delete content");
    }
}
