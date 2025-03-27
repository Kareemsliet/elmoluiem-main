<?php

use App\Http\Controllers\Api\MainController;
use App\Http\Controllers\Api\Student\AuthController as StudentAuthController;
use App\Http\Controllers\Api\Teacher\AuthController as TeacherAuthController;
use App\Http\Controllers\Api\Family\AuthController as FamilyAuthController;
use Illuminate\Support\Facades\Route;

    Route::group(["prefix" => "main"], function () {
        Route::get('/countries', [MainController::class, 'countries']);
        Route::get('{country_id}/education-systems', [MainController::class, 'educationsystems']);
        Route::get('{education_system_id}/education-levels', [MainController::class, 'educationlevels']);
        Route::get('{education_level_id}/subjects', [MainController::class, 'subjects']);
    });

    Route::post("/verification-email/send",[MainController::class,"sendVerificationCode"])->middleware(["auth:teacher,student,family","throttleApi:1,1"]);
    Route::post("/check-auth",[MainController::class,"checkAuth"]);

    Route::group(["prefix" => "student"], function () {

        Route::post('/register', [StudentAuthController::class, 'register']);
        Route::post('/login', [StudentAuthController::class, 'login']);
        Route::post('/update-password', [StudentAuthController::class, 'updatePassword']);

        Route::middleware('auth:student')->group(function () {
            Route::post("/verification-email/verify",[StudentAuthController::class,"verifyCode"]);
            Route::group(["middleware"=>"hasVerified"],function(){
                Route::get('/me',[StudentAuthController::class,"profile"]);
                Route::post("/me",[StudentAuthController::class,"updateProfile"]);
                Route::post('/logout', [StudentAuthController::class, 'logout']);
            });
        });

    });


    Route::group(["prefix" => "parent"], function () {
        
        Route::post('/register', [FamilyAuthController::class, 'register']);
        Route::post('/login', [FamilyAuthController::class, 'login']);
        Route::post('/update-password', [FamilyAuthController::class, 'updatePassword']);

        Route::middleware('auth:family')->group(function () {
            Route::post("/verification-email/verify",[FamilyAuthController::class,"verifyCode"]);
            Route::group(["middleware"=>"hasVerified"],function(){
                Route::get('/me',[FamilyAuthController::class,"profile"]);
                Route::post("/me",[FamilyAuthController::class,"updateProfile"]);
                Route::post('/logout', [FamilyAuthController::class, 'logout']);
            });
        });

    });


    Route::group(["prefix" => "teacher"], function () {
        
        Route::post('/register', [TeacherAuthController::class, 'register']);
        Route::post('/login', [TeacherAuthController::class, 'login']);
        Route::post('/update-password', [TeacherAuthController::class, 'updatePassword']);

        Route::middleware('auth:teacher')->group(function () {
            Route::post("/verification-email/verify",[TeacherAuthController::class,"verifyCode"]);
            Route::group(["middleware"=>"hasVerified"],function(){
                Route::get('/me',[TeacherAuthController::class,"profile"]);
                Route::post("/me",[TeacherAuthController::class,"updateProfile"]);
                Route::post('/logout', [TeacherAuthController::class, 'logout']);
            });
        });
    
    });

    

