<?php

namespace App\Http\Controllers\Api\Teacher;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Teacher\LoginRequest;
use App\Http\Requests\Api\Teacher\ProfileUpdateRequest;
use App\Http\Requests\Api\Teacher\RegisterRequest;
use App\Http\Resources\TeacherResource;
use App\Http\Services\ImageService;
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

    public function profile(Request $request)
    {
        $teacher = $request->user("teacher");

        return successResponse(data:new TeacherResource($teacher));
    }

    public function updateProfile(ProfileUpdateRequest $request)
    {
        $request->validated();

        $teacher = $request->user("teacher");

        $data = $request->only(["name", "email", "address", 'phone', "education_level_id", "gender","description","qualification","experince"]);

        if ($request->profile_image) {
            if ($teacher->profile_image) {
                (new ImageService())->destroyImage($teacher->profile_image, "teachers");
            }
            $data["profile_image"] = (new ImageService())->uploadImage($request->file("profile_image"), "teachers");
        }

        if ($request->cv) {
            if ($teacher->cv) {
                (new ImageService())->destroyImage($teacher->cv, "teachers");
            }
            $data["cv"] = (new ImageService())->uploadImage($request->file("cv"), "teachers");
        }

        if ($data["email"] != $teacher->email) {
        
            $data["email_verified_at"] = null;
        
            (new VerficationService())->sendEmailVerificationCode($teacher);
        }

        $teacher->update($data);

        $subjects=Subject::whereIn("id",$request->subjects)->get()->pluck("id")->toArray();

        $teacher->subjects()->sync($subjects);

        return successResponse(data:new TeacherResource($teacher));
    }

    public function updatePassword(Request $request)
    {
        $validation = validator($request->only(["password","password_confirmation"]), [
            "password" => "required|min:8|confirmed",
        ]);
        
        if ($validation->fails()) {
            return failResponse($validation->errors()->first());
        }

        $parent=$request->user("teacher");

        $parent->update([
            "password" => $request->input("password"),
        ]);

        return successResponse("Done! updated password");
    }

    public function forgetPassword(Request $request)
    {
        $validation = validator($request->only(["email"]), [
            "email" => "required|email|exists:teachers,email",
        ]);

        if ($validation->fails()) {
            return failResponse($validation->errors()->first());
        }

        $validation->validated();

        $teacher = Teacher::where("email", '=', $request->input("email"))->first();

        (new VerficationService())->sendResetPasswordVerificationCode($teacher);

        return successResponse("Done! reset password code sent to your email");
    }

    public function resetPassword(Request $request)
    {
        $validation = validator($request->only(["code", "password","password_confirmation"]), [
            "code" => "required|numeric|exists:teachers,reset_password_code",
            "password" => "required|min:8|confirmed",
        ]);

        if ($validation->fails()) {
            return failResponse($validation->errors()->first());
        }

        $validation->validated();

        $teacher = Teacher::where("reset_password_code", '=', $request->input("code"))->first();

        if (!now()->isBefore($teacher->reset_password_expired)) {
            return failResponse("The code is expired");
        }

        $teacher->update([
            "password" => Hash::make($request->input("password")),
        ]);

        return successResponse("Done! updated password");
    }

}
