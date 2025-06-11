<?php

namespace App\Http\Controllers\Api\Teacher\Quizzes;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Teacher\Quizzes\QuestionsRequest;
use App\Http\Resources\QuizzQuestionsResource;

class QuestionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    protected $teacher;

    public function __construct()
    {
        $this->teacher = auth("teacher")->user();
    }

    public function index($quiz_id)
    {
        $quiz = $this->teacher->quizzes()->find($quiz_id);

        if (!$quiz) {
            return failResponse("Quiz not found");
        }

        $questions = $quiz->questions()->orderByDesc("created_at")->get();

        return successResponse(data: QuizzQuestionsResource::collection($questions));
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(QuestionsRequest $request, $quiz_id)
    {
        $quiz = $this->teacher->quizzes()->find($quiz_id);

        if (!$quiz) {
            return failResponse("Quiz not found");
        }

        $request->validated();

        $data = $request->only(["title", "score"]);

        $options = collect($request->options)->unique();

        $correctOptionsCount = $options->where("is_correct", 1)->count();

        if ($correctOptionsCount > 1) {
            return failResponse("You can only have one correct option per question.");
        }

        if ($correctOptionsCount == 0) {
            return failResponse("You must have at least one correct option.");
        }

        $question = $quiz->questions()->create($data);

        $options->map(function ($option) use ($question) {
            $question->options()->create($option);
        });

        return successResponse("Question added successfully", new QuizzQuestionsResource($question));
    }

    /**
     * Display the specified resource.
     */
    public function show($quiz, string $id)
    {
        $quiz = $this->teacher->quizzes()->find($quiz);

        if (!$quiz) {
            return failResponse("Quiz not found");
        }

        $question = $quiz->questions()->find($id);

        if (!$question) {
            return failResponse("Question not found");
        }

        return successResponse(data: new QuizzQuestionsResource($question));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(QuestionsRequest $request, $quiz, string $id)
    {
        $quiz = $this->teacher->quizzes()->find($quiz);

        if (!$quiz) {
            return failResponse("Quiz not found");
        }

        $question = $quiz->questions()->find($id);

        if (!$question) {
            return failResponse("Question not found");
        }

        $data = $request->only(["title", "score"]);

        $question->update($data);

        if ($request->options) {

            $options = collect($request->options)->unique();

            $correctOptionsCount = $options->where("is_correct", 1)->count();

            if ($correctOptionsCount > 1) {
                return failResponse("You can only have one correct option per question.");
            }

            if ($correctOptionsCount == 0) {
                return failResponse("You must have at least one correct option.");
            }

            $question->options()->delete();

            $question->options()->createMany($options);
        }

        return successResponse("Question updated successfully", new QuizzQuestionsResource($question));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($quiz, string $id)
    {
        $quiz = $this->teacher->quizzes()->find($quiz);

        if (!$quiz) {
            return failResponse("Quiz not found");
        }

        $question = $quiz->questions()->find($id);

        if (!$question) {
            return failResponse("Question not found");
        }

        $question->options()->delete();

        $question->delete();

        return successResponse("Question deleted successfully");
    }
}
