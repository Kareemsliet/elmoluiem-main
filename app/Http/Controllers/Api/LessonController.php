<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ContentLecturesReource;
use App\Http\Resources\ContentReource;
use App\Http\Resources\LessonReource;
use App\Models\Lesson;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    public function lessonDetails($lesson_id)
    {
        $lesson = Lesson::find($lesson_id);

        if (!$lesson || !is_numeric($lesson_id)) {
            return failResponse("not found lesson");
        }

        return successResponse(data: new LessonReource($lesson));
    }
    public function allLessons(Request $request)
    {
        $search = $request->query("q", "");

        $lessons = Lesson::where("title", 'like', "%$search%")->orderByDesc("created_at")->offset(0)->limit(12)->get();

        return successResponse(data: LessonReource::collection($lessons));
    }
    public function contents($lesson_id)
    {
        $lesson = Lesson::find($lesson_id);

        if (!$lesson || !is_numeric($lesson_id)) {
            return failResponse("not found lesson");
        }

        $contents = $lesson->contents()->orderByDesc("created_at")->get();

        return successResponse(data: ContentReource::collection($contents));
    }
    public function lectures($lesson_id, $content_id)
    {
        $lesson = Lesson::find($lesson_id);

        if (!$lesson || !is_numeric($lesson_id)) {
            return failResponse("not found lesson");
        }

        $content = $lesson->contents()->find($content_id);

        if (!$content || !is_numeric($content_id)) {
            return failResponse("not found content");
        }

        $lectures = $content->lectures()->orderByDesc("created_at")->get();

        return successResponse(data: ContentLecturesReource::collection($lectures));
    }
}
