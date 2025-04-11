<?php

namespace App\Http\Controllers\Api\Teacher\Lessons;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Teacher\Lessons\LessonRequest;
use App\Http\Resources\LessonReource;
use App\Http\Services\ImageService;
use App\Models\Lesson;

class LessonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $teacher;

    public function __construct()
    {
        $this->teacher = auth("teacher")->user();
    }

    public function index()
    {
        $lessons = $this->teacher->lessons()->orderByDesc("created_at")->get();
        return successResponse(data: LessonReource::collection($lessons));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LessonRequest $request)
    {
        $request->validated();

        $data = $request->only(["title", "description", "price"]);

        $logo = (new ImageService())->uploadImage($request->file("logo"), "teachers/lessons");

        $data["logo"] = $logo;

        $lesson = $this->teacher->lessons()->create($data);

        return successResponse("success add lesson", new LessonReource($lesson));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $lesson = Lesson::find($id);

        if (!is_numeric($id) || !$lesson) {
            return failResponse("not found lesson");
        }

        return successResponse(data: new LessonReource($lesson));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(LessonRequest $request, string $id)
    {
        $request->validated();

        $lesson = Lesson::find($id);

        if (!is_numeric($id) || !$lesson) {
            return failResponse("not found lesson");
        }

        $data = $request->only(["title", "description", "price"]);

        if ($request->logo) {
            (new ImageService())->destroyImage($lesson->logo, "teachers/lessons");

            $logo = (new ImageService())->uploadImage($request->file("logo"), "teachers/lessons");

            $data["logo"] = $logo;
        }

        $lesson->update($data);

        return successResponse("success update lesson", new LessonReource($lesson));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $lesson = Lesson::find($id);

        if (!is_numeric($id) || !$lesson) {
            return failResponse("not found lesson");
        }

        (new ImageService())->destroyImage($lesson->logo, "teachers/lessons");

        if($lesson->enrollments->count() > 0){
            return failResponse("you can't delete lesson, because it has enrollments");
        }

        if ($lesson->contents->count() > 0) {
            $lesson->contents()->delete();
        }

        $lesson->delete();

        return successResponse("success delete lesson");
    }
}
