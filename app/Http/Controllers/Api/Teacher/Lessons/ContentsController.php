<?php

namespace App\Http\Controllers\Api\Teacher\Lessons;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Teacher\Lessons\ContentRequest;
use App\Http\Resources\ContentReource;
use App\Models\Lesson;

class ContentsController extends Controller
{
    public function index($lesson_id)
    {
        $lesson = Lesson::find($lesson_id);

        if (!is_numeric($lesson_id) || !$lesson) {
            return failResponse("not found lesson");
        }

        $contents = $lesson->contents()->orderByDesc("created_at")->get();
        
        return successResponse(data:ContentReource::collection($contents));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ContentRequest $request,$lesson_id)
    {
        $lesson = Lesson::find($lesson_id);

        if (!is_numeric($lesson_id) || !$lesson) {
            return failResponse("not found lesson");
        }

        $request->validated();

        $data = $request->only(["title", "description"]);

        $content = $lesson->contents()->create($data);

        return successResponse("success add content", new ContentReource($content));
    }

    /**
     * Display the specified resource.
     */
    public function show($lesson_id,$id)
    {
        $lesson = Lesson::find($lesson_id);

        if (!is_numeric($lesson_id) || !$lesson) {
            return failResponse("not found lesson");
        }

        $content=$lesson->contents()->find($id);

        if(!is_numeric($id) || !$content) {
            return failResponse("not found content");
        }

        return successResponse(data: new ContentReource($content));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ContentRequest $request,$lesson_id,$id)
    {
        $request->validated();

        $lesson = Lesson::find($lesson_id);

        if (!is_numeric($lesson_id) || !$lesson) {
            return failResponse("not found lesson");
        }

        $content=$lesson->contents()->find($id);

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
    public function destroy($lesson_id,$id)
    {
        $lesson = Lesson::find($lesson_id);

        if (!is_numeric($lesson_id) || !$lesson) {
            return failResponse("not found lesson");
        }

        $content=$lesson->contents()->find($id);

        if(!is_numeric($id) || !$content) {
            return failResponse("not found content");
        }

        $content->delete();

        return successResponse("success delete content");
    }
}
