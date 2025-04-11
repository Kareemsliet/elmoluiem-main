<?php

namespace App\Http\Controllers\Api\Student;

use App\Enums\PaymentStatusEnums;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Main\RatingRequest;
use App\Http\Requests\Api\Student\PaymentInitiateRequest;
use App\Http\Resources\CourseResource;
use App\Http\Resources\LessonReource;
use App\Http\Resources\RatingResource;
use App\Http\Services\PaymobService;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Teacher;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MainController extends Controller
{
    public $student;

    public function __construct()
    {
        $this->student = auth("student")->user();
    }

    public function rateTeacher(RatingRequest $request, $teacher_id)
    {

        $request->validated();

        $teacher = Teacher::find($teacher_id);

        if (!is_numeric($teacher_id) || !$teacher) {
            return failResponse("not found teacher");
        }

        $this->student->teacherRatings()->attach($teacher_id, [
            "rate" => $request->rate,
            "description" => $request->description,
        ]);

        return successResponse("success add rate");
    }

    public function allGivenRatings()
    {
        $ratings = Teacher::all()->map(function ($item) {
            return $item->studentRatingsAboutMe()->where("students.id", '=', $this->student->id)->get();
        })
            ->flatten()
            ->sortByDesc(function ($item) {
                $item->pivot->created_at;
            });

        return successResponse(data: RatingResource::collection($ratings));
    }

    public function allReceivedRatings()
    {
        $ratings = $this->student->teacherRatingsAboutMe()->orderByPivot("created_at", 'desc')->get();

        return successResponse(data: RatingResource::collection($ratings));
    }

    public function intiatePayment(PaymentInitiateRequest $request)
    {
        $request->validated();

        $orderable = null;

        $enrolled = false;

        $data = [
            "name" => $this->student->name,
            "email" => $this->student->email,
            "phone" => $this->student->phone,
            "orderable_id" => $request->input("orderable_id"),
            "orderable_type" => $request->input("orderable_type"),
            "amount" => $request->input("amount"),
            "student_id" => $this->student->id,
        ];

        if ($request->input("orderable_type") == "lessons") {
            $orderable = Lesson::find($request->input("orderable_id"));

            $enrolled = $this->student->enrollingLessons()
                ->where("lessons.id", "=", $request->input("orderable_id"))
                ->exists();
        }

        if ($request->input("orderable_type") == "courses") {

            $orderable = Course::find($request->input("orderable_id"));

            $enrolled = $this->student->enrollingCourses()
                ->where("courses.id", "=", $request->input("orderable_id"))
                ->exists();
        }

        if ($enrolled) {
            return failResponse("you are  enrolled in this course");
        }

        $paymentData = (new PaymobService())->generatePaymentData($data);

        $orderable->orders()->create([
            "student_id" => $this->student->id,
            "amount" => $request->input("amount"),
            "paymob_order_id" => $paymentData["orderId"],
            "status" => PaymentStatusEnums::PENDING,
        ]);

        $paymentResource = (new PaymobService())->payWithPaymob($paymentData["paymentToken"], $request->input("wallet_number"));

        return successResponse("please check your wallet", [
            "redirect_url" => $paymentResource["redirect_url"],
        ]);
    }

    public function callbackPayment(Request $request)
    {
        if (!$request->hmac) {
            return failResponse("invalid request");
        }

        if (!$request->success) {
            return failResponse("payment failed");
        }

        $order = $this->student->orders()->where([
            ["paymob_order_id", "=", $request->order],
            ["status", "=", PaymentStatusEnums::PENDING],
        ])->first();

        if (!$order) {
            return failResponse("not found order or already paid");
        }

        $orderable = $order->orderable;

        DB::transaction(function () use ($orderable, $order, $request) {
            $order->update([
                "status" => PaymentStatusEnums::SUCCESS,
                "transaction_id" => $request->id,
            ]);

            if ($orderable->getTable() == "lessons") {
                $this->student->enrollingLessons()->attach($orderable->id);
            }

            if ($orderable->getTable() == "courses") {
                $this->student->enrollingCourses()->attach($orderable->id);
            }

            $total = $order->amount;

            if ($orderable->getTable() == "lessons") {

                $commission = 0.10;

                $teacher_amount = $total - ($total * $commission);

                $platform_amount = $total * $commission;

                $orderable->teacher->transactions()->create([
                    "total" => $total,
                    "commission" => $commission,
                    "teacher_amount" => $teacher_amount,
                    "commission_amount" => $platform_amount,
                ]);
            }

            if ($orderable->getTable() == "courses") {
                Transaction::create([
                    "total" => $total,
                    "commission" => 0.0,
                ]);
            }

        });

        return successResponse("payment success and you are enrolled in this course");
    }

    public function enrollingLessons()
    {
        $enrollingLessons = $this->student->enrollingLessons()->orderByPivot("created_at", "desc")->get();

        return successResponse(data: LessonReource::collection($enrollingLessons));
    }

    public function enrollingCourses()
    {
        $enrollingCourses = $this->student->enrollingCourses()->orderByPivot("created_at", "desc")->get();

        return successResponse(data: CourseResource::collection($enrollingCourses));
    }

    public function enrollLesson($lesson_id)
    {

        $lsesson = Lesson::find($lesson_id);

        if (!$lsesson || !is_numeric($lesson_id)) {
            return failResponse("not found lesson");
        }

        $existsLesson = $this->student->enrollingLessons()->where("lessons.id", "=", $lesson_id)->exists();

        if ($existsLesson) {
            return failResponse("you are already enrolled in this lesson");
        }

        if ((int) $lsesson->price > 0) {
            return failResponse("this lesson is paid lesson");
        }

        $this->student->enrollingLessons()->attach($lesson_id);

        return successResponse("success enroll in this lesson");
    }

    public function enrollCourse($course_id)
    {

        $course = Course::find($course_id);

        if (!$course || !is_numeric($course_id)) {
            return failResponse("not found course");
        }

        $existsCourse = $this->student->enrollingCourses()->where("courses.id", "=", $course_id)->exists();

        if ($existsCourse) {
            return failResponse("you are already enrolled in this course");
        }

        if ((int) $course->price > 0) {
            return failResponse("this course is paid course");
        }

        $this->student->enrollingCourses()->attach($course->id);

        return successResponse("success enroll in this course");
    }


}
