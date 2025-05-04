<?php

use App\Http\Controllers\Api\CoursesController;
use App\Http\Controllers\Api\MainController;
use App\Http\Controllers\Api\Student\AuthController as StudentAuthController;
use App\Http\Controllers\Api\Teacher\AuthController as TeacherAuthController;
use App\Http\Controllers\Api\Family\AuthController as FamilyAuthController;
use App\Http\Controllers\Api\Teacher\Lessons\ContentsController;
use App\Http\Controllers\Api\Teacher\Lessons\LecturesController;
use App\Http\Controllers\Api\Teacher\Lessons\LessonController;
use App\Http\Controllers\Api\Student\MainController as StudentMainController;
use App\Http\Controllers\Api\Teacher\MainController as TeacherMainController;
use App\Http\Controllers\Api\Family\MainController as FamilyMainController;
use App\Http\Controllers\Api\Teacher\Courses\CoursesController as TeacherCoursesController;
use App\Http\Controllers\Api\Teacher\Courses\ContentsController as TeacherContentsCoursesController;
use App\Http\Controllers\Api\Teacher\Courses\LectureController as TeacherLecturesCoursesController;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Route;

Route::group(["prefix" => "main"], function () {
    Route::get('/countries', [MainController::class, 'countries']);
    Route::get('{country_id}/education-systems', [MainController::class, 'educationsystems']);
    Route::get('{education_system_id}/education-levels', [MainController::class, 'educationlevels']);
    Route::get('{education_level_id}/subjects', [MainController::class, 'subjects']);
    Route::get("/teachers/{teacher_id}/details",[MainController::class,"teacherDetails"]);
});

Route::group(["prefix"=>"general"],function(){
    Route::get("/categories", [MainController::class, "categories"]);
    Route::get("/{category_id}/sub-categories", [MainController::class, "subCategories"]);
    Route::get("/{sub_category_id}/courses/", [MainController::class, "courses"]);
});

Route::get("/courses/all", [CoursesController::class, "allCourses"]);

Route::group(["prefix" => "/courses/{course_id}/"], function () {
    Route::get("/contents", [CoursesController::class, "contents"]);
    Route::get("/{content_id}/lectures", [CoursesController::class, "lectures"])->middleware("auth:sanctum");
});

Route::post("/verification-email/send", [MainController::class, "sendVerificationCode"])->middleware(["auth:teacher,student,family", "throttleApi:1,1"]);
Route::post("/check-auth", [MainController::class, "checkAuth"]);

Broadcast::routes(["middleware"=>"auth:sanctum"]);

Route::group(["prefix" => "student"], function () {

    Route::post('/register', [StudentAuthController::class, 'register']);
    Route::post('/login', [StudentAuthController::class, 'login']);
    Route::post("/forget-password", [StudentAuthController::class, "forgetPassword"])->middleware("throttleApi:1,1");
    Route::post("/reset-password", [StudentAuthController::class, "resetPassword"]);

    Route::middleware('auth:student')->group(function () {
        Route::post("/verification-email/verify", [StudentAuthController::class, "verifyCode"]);
        Route::post('/logout', [StudentAuthController::class, 'logout']);
        Route::group(["middleware" => "hasVerified"], function () {
            Route::post('/update-password', [StudentAuthController::class, 'updatePassword']);
            Route::get('/me', [StudentAuthController::class, "profile"]);
            Route::post("/me", [StudentAuthController::class, "updateProfile"]);
            Route::group(["prefix" => "rating"], function () {
                Route::post("/{teacher_id}/rate", [StudentMainController::class, "rateTeacher"]);
                Route::get("/given-all", [StudentMainController::class, "allGivenRatings"]);
                Route::get("/received-all", [StudentMainController::class, "allReceivedRatings"]);
            });
            Route::group(["prefix" => "payment"], function () {
                Route::post("/intiate", [StudentMainController::class, "intiatePayment"])->middleware("throttleApi:1,1");
                Route::get("/callback", [StudentMainController::class, "callbackPayment"]);
            });
            Route::group(["prefix" => "enrolling"], function () {
                Route::get("/lessons", [StudentMainController::class, "enrollingLessons"]);
                Route::get("/courses", [StudentMainController::class, "enrollingCourses"]);
                Route::post("/lessons/{lesson_id}/enroll", [StudentMainController::class, "enrollLesson"]);
                Route::post("/courses/{course_id}/enroll", [StudentMainController::class, "enrollCourse"]);
            });
        });
    });
});


Route::group(["prefix" => "parent"], function () {

    Route::post('/register', [FamilyAuthController::class, 'register']);
    Route::post('/login', [FamilyAuthController::class, 'login']);
    Route::post("/forget-password", [FamilyAuthController::class, "forgetPassword"])->middleware("throttleApi:1,1");
    Route::post("/reset-password", [FamilyAuthController::class, "resetPassword"]);

    Route::middleware('auth:family')->group(function () {
        Route::post("/verification-email/verify", [FamilyAuthController::class, "verifyCode"]);
        Route::post('/logout', [FamilyAuthController::class, 'logout']);
        Route::group(["middleware" => "hasVerified"], function () {
            Route::post('/update-password', [FamilyAuthController::class, 'updatePassword']);
            Route::get('/me', [FamilyAuthController::class, "profile"]);
            Route::post("/me", [FamilyAuthController::class, "updateProfile"]);
            Route::group(["prefix" => "ratings"], function () {
                Route::get("/all", [FamilyMainController::class, "allRatings"]);
                Route::post("/{teacher_id}/rate", [FamilyMainController::class, "rateTeacher"]);
                Route::get("/my-students/ratings", [FamilyMainController::class, "studentsRatings"]);
            });
        });
    });
});

Route::group(["prefix" => "teacher"], function () {

    Route::post('/register', [TeacherAuthController::class, 'register']);
    Route::post('/login', [TeacherAuthController::class, 'login']);
    Route::post("/forget-password", [TeacherAuthController::class, "forgetPassword"])->middleware("throttleApi:1,1");
    Route::post("/reset-password", [TeacherAuthController::class, "resetPassword"]);

    Route::middleware('auth:teacher')->group(function () {
        Route::post("/verification-email/verify", [TeacherAuthController::class, "verifyCode"]);
        Route::post('/logout', [TeacherAuthController::class, 'logout']);
        Route::group(["middleware" => "hasVerified"], function () {
            
            Route::post('/update-password', [TeacherAuthController::class, 'updatePassword']);
            Route::get('/me', [TeacherAuthController::class, "profile"]);
            Route::post("/me", [TeacherAuthController::class, "updateProfile"]);
            
            Route::group(["prefix" => "ratings"], function () {
                Route::post("/{student_id}/rate", [TeacherMainController::class, "rateStudent"]);
                Route::get("/given-all", [TeacherMainController::class, "allGivenRatings"]);
                Route::get("/received-all", [TeacherMainController::class, "allReceivedRatings"]);
            });
            
            Route::group(["prefix" => "wallet"], function () {
                Route::get("/", [TeacherMainController::class, "myWallet"]);
                Route::get("/payouts", [TeacherMainController::class, "payouts"]);
                Route::post("/payout", [TeacherMainController::class, "createPayout"]);
            });

            Route::group(["prefix" => "lessons", "as" => "lessons."], function () {
                Route::apiResource("/", LessonController::class)->parameters([""=>"lesson_id"]);
                Route::apiResource("/{lesson_id}/contents", ContentsController::class);
                Route::apiResource("{lesson_id}/contents/{content_id}/lectures", LecturesController::class);
                Route::post("/{lesson_id}/contents/{content_id}/lectures/{id}/video-upload", [LecturesController::class, "uploadVideo"])->middleware("throttleApi:2,1");
            });

            Route::group(["prefix" => "courses", "as" => "courses."], function () {
                Route::apiResource("/", TeacherCoursesController::class)->parameter("","course_id");
                Route::apiResource("/{course_id}/contents", TeacherContentsCoursesController::class);
                Route::apiResource("/{course_id}/contents/{content_id}/lectures", TeacherLecturesCoursesController::class);
                Route::post("/{course_id}/contents/{content_id}/lectures/{id}/video-upload", [TeacherLecturesCoursesController::class, "uploadVideo"])->middleware("throttleApi:2,1");
            });

        });
    });
});

require_once __DIR__ . '/chat.php';
