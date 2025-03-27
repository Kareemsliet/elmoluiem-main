<?php

namespace App\Http\Controllers\Api\Teacher;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Teacher\LoginRequest;
use App\Http\Requests\Api\Teacher\RegisterRequest;
use App\Http\Requests\Api\Teacher\UpdatePasswordRequest;
use App\Http\Resources\TeacherResource;
use App\Http\Services\VerficationService;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $request->validated();

        $teacher = Teacher::where("email", '=', $request->input("email"))->first();

        if(!$teacher){
            return failResponse(__("auth.failed"));
        }

        if(!Hash::check($request->password,$teacher->password)){
            return failResponse(__("auth.failed"));
        }

        if($teacher->tokens->count() > 0 ){
            $teacher->tokens()->delete();
        }

        $token = $teacher->createToken("teacher")->plainTextToken;

        return successResponse("success login",[
            "token" => $token,
        ]);
    }

    public function register(RegisterRequest $request)
    {
        $request->validated();

        $data=$request->only(["name","email","password",'phone',"course_type","education_level_id","gender"]);

        $teacher=Teacher::create($data);

        $subjects=Subject::whereIn("id",$request->subjects)->get()->pluck("id")->toArray();

        $teacher->subjects()->sync($subjects);

        $token = $teacher->createToken("teacher")->plainTextToken;

        (new VerficationService())->sendEmailVerificationCode($teacher);

        return successResponse("success register",[
            "token" => $token,
        ]);
    }

    public function logout(Request $request)
    {
        $teacher=$request->user("teacher");

        $teacher->currentAccessToken()->delete();

        return successResponse("success logout");
    }

    public function updatePassword(UpdatePasswordRequest $request)
    {
        $request->validated();

        $teacher=Teacher::where("email",'=',$request->input("email"))->first();

        $teacher->update([
            "password"=>$request->input("password"),
        ]);

        return successResponse("Done! updated password");
    }

    public function verifyCode(Request $request){
        
        $validation=validator($request->only(["code"]),[
            "code"=>"required|numeric|exists:teachers,email_verified_code",
        ]);

        if($validation->fails()){
            return failResponse($validation->errors()->first());
        }

        $validation->validated();

        $teacher=Teacher::where("email_verified_code",'=',$request->input("code"))->first();

        if(!now()->isBefore($teacher->email_verified_expired)){
            return failResponse("The code is expired");
        }

        $teacher->update([
            "email_verified_at"=>now(),
        ]);

        return successResponse("Success Verification Email");
    }

}
