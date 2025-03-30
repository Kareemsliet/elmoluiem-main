<?php

namespace App\Http\Controllers\Api\Teacher\Lessons;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Teacher\Lessons\LectureRequest;
use App\Http\Resources\ContentLecturesReource;
use App\Http\Services\ImageService;
use App\Models\Content;

class LecturesController extends Controller
{
    public function index($content_id)
    {
        $content = Content::find($content_id);

        if (!is_numeric($content_id) || !$content) {
            return failResponse("not found content");
        }

        $lectures = $content->lectures()->orderByDesc("created_at")->get();

        return successResponse(data: ContentLecturesReource::collection($lectures));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LectureRequest $request, $content_id)
    {
        $content = Content::find($content_id);

        if (!is_numeric($content_id) || !$content) {
            return failResponse("not found content");
        }

        $request->validated();

        $data = $request->only(["title", "description", "deuration"]);

        $video = (new ImageService())->uploadImage($request->file("video"), "teachers/lessons/lectures");

        $data["video"] = $video;

        $lecture = $content->lectures()->create($data);

        return successResponse("success add lecture", new ContentLecturesReource($lecture));
    }

    /**
     * Display the specified resource.
     */
    public function show($content_id, $id)
    {
        $content = Content::find($content_id);

        if (!is_numeric($content_id) || !$content) {
            return failResponse("not found content");
        }

        $lecture = $content->lectures()->find($id);

        if (!is_numeric($id) || !$lecture) {
            return failResponse("not found lecture");
        }

        return successResponse(data: new ContentLecturesReource($lecture));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(LectureRequest $request, $content_id, $id)
    {
        $request->validated();

        $content = Content::find($content_id);

        if (!is_numeric($content_id) || !$content) {
            return failResponse("not found content");
        }

        $lecture = $content->lectures()->find($id);

        if (!is_numeric($id) || !$lecture) {
            return failResponse("not found lecture");
        }

        $data = $request->only(["title", "description", "deuration"]);

        if ($request->video) {

            (new ImageService())->destroyImage($lecture->video,"teachers/lessons/lectures");

            $video = (new ImageService())->uploadImage($request->file("video"), "teachers/lessons/lectures");

            $data["video"] = $video;
        }

        $lecture->update($data);

        return successResponse("success update lecture", new ContentLecturesReource($lecture));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($content_id, $id)
    {
        $content = Content::find($content_id);

        if (!is_numeric($content_id) || !$content) {
            return failResponse("not found content");
        }

        $lecture = $content->lectures()->find($id);

        if (!is_numeric($id) || !$lecture) {
            return failResponse("not found lecture");
        }

        (new ImageService())->destroyImage($lecture->video,"teachers/lessons/lectures");

        $lecture->delete();

        return successResponse("success delete lecture");
    }
}
