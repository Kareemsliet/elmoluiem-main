<?php

namespace App\Http\Controllers\Api\Teacher\Quizzes;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Teacher\Quizzes\QuizRequest;
use App\Http\Resources\QuizzResource;

class QuizzesController extends Controller
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
        $quizzes = $this->teacher->quizzes()->orderByDesc("created_at")->get();
        return successResponse(data: QuizzResource::collection($quizzes));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(QuizRequest $request)
    {
        $request->validated();

        $data = $request->only(["title", "time_limit", "education_level_id", "subject_id", "start_time", "end_time", "date", "academic_year"]);

        $quiz = $this->teacher->quizzes()->create($data);

        return successResponse("success add quiz", new QuizzResource($quiz));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $quiz = $this->teacher->quizzes()->find($id);

        if (!is_numeric($id) || !$quiz) {
            return failResponse("not found quiz");
        }

        return successResponse(data: new QuizzResource($quiz));
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(QuizRequest $request, string $id)
    {
        $request->validated();

        $quiz = $this->teacher->quizzes()->find($id);

        if (!is_numeric($id) || !$quiz) {
            return failResponse("not found quiz");
        }

        $data = $request->only(["title", "time_limit", "education_level_id", "subject_id", "start_time", "end_time", "date", "academic_year"]);

        $quiz->update($data);

        return successResponse("success update quiz", new QuizzResource($quiz));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $quiz = $this->teacher->quizzes()->find($id);

        if (!is_numeric($id) || !$quiz) {
            return failResponse("not found quiz");
        }

        $quiz->questions()->delete();

        $quiz->delete();

        return successResponse("success delete quiz");
    }
}
