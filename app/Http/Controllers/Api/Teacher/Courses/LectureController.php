<?php

namespace App\Http\Controllers\Api\Teacher\Courses;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Teacher\Lessons\LectureRequest;
use App\Http\Resources\ContentLecturesReource;
use App\Http\Services\ViemoService;
use App\Models\Course;
use Illuminate\Http\Request;

class LectureController extends Controller
{
    public function index($course_id,$content_id)
    {
        $course= Course::find($course_id);

        if (!is_numeric($course_id) || !$course) {
            return failResponse("not found course");
        }

        $content = $course->contents()->find($content_id);

        if (!is_numeric($content_id) || !$content) {
            return failResponse("not found content");
        }

        $lectures = $content->lectures()->orderByDesc("created_at")->get();

        return successResponse(data: ContentLecturesReource::collection($lectures));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LectureRequest $request,$course_id,$content_id)
    {
        $course= Course::find($course_id);

        if (!is_numeric($course_id) || !$course) {
            return failResponse("not found course");
        }

        $content = $course->contents()->find($content_id);

        if (!is_numeric($content_id) || !$content) {
            return failResponse("not found content");
        }

        $request->validated();

        $data = $request->only(["title", "description"]);

        $lecture = $content->lectures()->create($data);

        return successResponse("success add lecture", new ContentLecturesReource($lecture));
    }

    /**
     * Display the specified resource.
     */
    public function show($course_id,$content_id,$id)
    {
        $course= Course::find($course_id);

        if (!is_numeric($course_id) || !$course) {
            return failResponse("not found course");
        }

        $content = $course->contents()->find($content_id);

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
    public function update(LectureRequest $request,$course_id,$content_id, $id)
    {
        $request->validated();

        $course= Course::find($course_id);

        if (!is_numeric($course_id) || !$course) {
            return failResponse("not found course");
        }

        $content = $course->contents()->find($content_id);

        if (!is_numeric($content_id) || !$content) {
            return failResponse("not found content");
        }

        $lecture = $content->lectures()->find($id);

        if (!is_numeric($id) || !$lecture) {
            return failResponse("not found lecture");
        }

        $data = $request->only(["title", "description"]);

        $lecture->update($data);

        return successResponse("success update lecture", new ContentLecturesReource($lecture));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($course_id,$content_id, $id)
    {
        $course= Course::find($course_id);

        if (!is_numeric($course_id) || !$course) {
            return failResponse("not found course");
        }

        $content = $course->contents()->find($content_id);

        if (!is_numeric($content_id) || !$content) {
            return failResponse("not found content");
        }

        $lecture = $content->lectures()->find($id);

        if (!is_numeric($id) || !$lecture) {
            return failResponse("not found lecture");
        }

        if ($lecture->video) {
            (new ViemoService())->deleteVideo($lecture->video);
        }

        $lecture->delete();

        return successResponse("success delete lecture");
    }

    public function uploadVideo(Request $request,$course_id,$content_id, $id)
    {
        $course= Course::find($course_id);

        if (!is_numeric($course_id) || !$course) {
            return failResponse("not found course");
        }

        $content = $course->contents()->find($content_id);

        if (!is_numeric($content_id) || !$content) {
            return failResponse("not found content");
        }

        $lecture = $content->lectures()->find($id);

        if (!is_numeric($id) || !$lecture) {
            return failResponse("not found lecture");
        }

        $validation = validator()->make($request->only(["video"]), [
            "video" => "required|mimes:mp4,mov,avi,wmv|max:20000",
        ]);

        if ($validation->fails()) {
            return failResponse($validation->errors()->first());
        }

        $validation->validated();

        if($lecture->video){
            (new ViemoService())->deleteVideo($lecture->video);
        }

        $videoPath = $request->file("video")->getRealPath();

        $videoId=(new ViemoService())->uploadVideo($videoPath,$lecture->title, $lecture->description);

        $videoDuration=(new ViemoService())->getVideoDeuration($videoId);

        $lecture->update([
            "video"=>$videoId,
            "deuration"=>$videoDuration,
        ]);

        return successResponse("success upload video", new ContentLecturesReource($lecture));
    }

}
