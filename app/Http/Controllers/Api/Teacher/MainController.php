<?php

namespace App\Http\Controllers\Api\Teacher;
use App\Enums\PaymentStatusEnums;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Main\RatingRequest;
use App\Http\Resources\PayoutResource;
use App\Http\Resources\RatingResource;
use App\Http\Services\PaymobTransfer;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Student;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public $teacher;

    public function __construct()
    {
        $this->teacher = auth("teacher")->user();
    }

    public function rateStudent(RatingRequest $request, $student_id)
    {
        $request->validated();

        $student = Student::find($student_id);

        if (!is_numeric($student_id) || !$student) {
            return failResponse("not found student");
        }

        $this->teacher->studentRatings()->attach($student_id, [
            "rate" => $request->rate,
            "description" => $request->description,
        ]);

        return successResponse("success add rate");
    }

    public function allReceivedRatings()
    {
        $receivesRatings = collect([$this->teacher->studentRatingsAboutMe, $this->teacher->familyRatingsAboutMe])->flatten()->sortByDesc(function ($item) {
            $item->pivot->created_at;
        });

        return successResponse(data: RatingResource::collection($receivesRatings));
    }

    public function allGivenRatings()
    {
        $givenRatings = Student::all()->map(function ($item) {
            return $item->teacherRatingsAboutMe()->where("teachers.id", '=', $this->teacher->id)->get();
        })
            ->flatten()
            ->sortByDesc(function ($item) {
                $item->pivot->created_at;
            });

        return successResponse(data: RatingResource::collection($givenRatings));
    }

    public function myWallet()
    {
        $total = $this->teacher->transactions()->sum("teacher_amount");

        $lessons = $this->teacher->lessons()->pluck("id")->toArray();

        $courses = $this->teacher->courses()->pluck("id")->toArray();

        $countLessonsEnrollments = Lesson::whereIn("id", $lessons)->get()->map(function ($item) {
            return $item->enrollments;
        })
        ->flatten()
        ->count();

        $countCoursesEnrollments = Course::whereIn("id", $courses)->get()->map(function ($item) {
            return $item->enrollments;
        })
        ->flatten()
        ->count();

        return successResponse(data: [
            "total" => $total,
            "lesson_enrollments" => $countLessonsEnrollments,
            "course_enrollments" => $countCoursesEnrollments,
            "withdrawn" => 0.0,
        ]);
    }

    public function createPayout(Request $request)
    {

        $balance = $this->teacher->transactions()->sum("teacher_amount") - $this->teacher->payouts()->sum("amount");

        $validation = validator()->make($request->only("amount", "wallet_number"), [
            "amount" => "required|numeric|min:5|max:" . $balance,
            "wallet_number" => "required|numeric",
        ]);

        if ($validation->fails()) {
            return failResponse($validation->errors());
        }

        $validation->validated();

        $data = [
            "name" => $this->teacher->name,
            "email" => $this->teacher->email,
            "phone" => $this->teacher->phone,
            "amount" => $request->amount,
            "wallet_number" => $request->wallet_number,
        ];

        $payoutResponse = (new PaymobTransfer())->transfer($data);

        $payout = $this->teacher->payouts()->create([
            "amount" => $request->amount,
            "status" => PaymentStatusEnums::PENDING,
        ]);

        return successResponse("success payout", data: new PayoutResource($payout));
    }

    public function payouts()
    {

        $payouts = $this->teacher->payouts()->orderBy("created_at", "desc")->get();

        return successResponse(data: PayoutResource::collection($payouts));
    }

}
