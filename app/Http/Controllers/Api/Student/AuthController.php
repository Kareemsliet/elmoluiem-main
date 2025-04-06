<?php

namespace App\Http\Controllers\Api\Student;

use App\Enums\VerificationTypeEnums;
use App\Http\Requests\Api\Student\ProfileUpdateRequest;
use App\Http\Resources\StudentResource;
use App\Http\Services\ImageService;
use App\Http\Services\VerficationService;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Student\LoginRequest;
use App\Http\Requests\Api\Student\RegisterRequest;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $request->validated();

        $student = Student::where("email", '=', $request->input("email"))->first();

        if (!$student) {
            return failResponse(__("auth.failed"));
        }

        if (!Hash::check($request->password, $student->password)) {
            return failResponse(__("auth.failed"));
        }

        if ($student->tokens->count() > 0) {
            $student->tokens()->delete();
        }

        $token = $student->createToken("student")->plainTextToken;

        return successResponse("success login", [
            "token" => $token,
        ]);
    }

    public function register(RegisterRequest $request)
    {
        $request->validated();

        $data = $request->only(["name", "email", "password", "address", 'phone', "education_level_id", "gender"]);

        $student = Student::create($data);

        $token = $student->createToken("student")->plainTextToken;

        (new VerficationService())->sendEmailVerificationCode($student);

        return successResponse("success register done", [
            "token" => $token,
        ]);
    }

    public function logout(Request $request)
    {
        $student = $request->user("student");

        $student->currentAccessToken()->delete();

        return successResponse("success logout");
    }

    public function verifyCode(Request $request)
    {

        $validation = validator($request->only(["code"]), [
            "code"=>"required|numeric|min:6",
        ]);

        if ($validation->fails()) {
            return failResponse($validation->errors()->first());
        }

        $validation->validated();

        $student = Student::whereHas("verifications",function($query)use($request){
            $query->where([
                ["type",'=',VerificationTypeEnums::Email],
                ["code",'=',$request->input("code")],
                ["uses",'=',0],
                ["expired_at",'>',now()],
            ]);
        })->first();

        if (!$student) {
            return failResponse("The code is not valid");
        }

        $student->update([
            "email_verified_at" => now(),
        ]);

        $student->verifications()->where([
            ["type",'=',VerificationTypeEnums::Email],
            ["code",'=',$request->input("code")],
            ["uses",'=',0],
        ])->update([
            "uses" => 1,
        ]);

        return successResponse("Success Verification Email");
    }

    public function profile(Request $request)
    {
        $student = $request->user("student");

        return successResponse(data: new StudentResource($student));
    }

    public function updateProfile(ProfileUpdateRequest $request)
    {
        $request->validated();

        $student = $request->user("student");

        $data = $request->only(["name", "email", "address", 'phone', "education_level_id", "gender", "description"]);

        if ($request->profile_image) {
            if ($student->profile_image) {
                (new ImageService())->destroyImage($student->profile_image, "students");
            }
            $data["profile_image"] = (new ImageService())->uploadImage($request->file("profile_image"), "students");
        }

        if ($data["email"] != $student->email) {

            $data["email_verified_at"] = null;

            (new VerficationService())->sendEmailVerificationCode($student);
        }

        $student->update($data);

        $favourite_subjects=$request->input("favourite_subjects",[]);

        $student->subjects()->sync($favourite_subjects);

        return successResponse(data: new StudentResource($student));
    }

    public function updatePassword(Request $request)
    {
        $validation = validator($request->only(["password", "password_confirmation"]), [
            "password" => "required|min:8|confirmed",
        ]);

        if ($validation->fails()) {
            return failResponse($validation->errors()->first());
        }

        $parent = $request->user("student");

        $parent->update([
            "password" => $request->input("password"),
        ]);

        return successResponse("Done! updated password");
    }

    public function forgetPassword(Request $request)
    {
        $validation = validator($request->only(["email"]), [
            "email" => "required|email|exists:students,email",
        ]);

        if ($validation->fails()) {
            return failResponse($validation->errors()->first());
        }

        $validation->validated();

        $student = Student::where("email", '=', $request->input("email"))->first();

        (new VerficationService())->sendResetPasswordVerificationCode($student);

        return successResponse("Done! reset password code sent to your email");
    }

    public function resetPassword(Request $request)
    {
        $validation = validator($request->only(["code", "password", "password_confirmation"]), [
            "code"=>"required|numeric|min:6",
            "password" => "required|min:8|confirmed",
        ]);

        if ($validation->fails()) {
            return failResponse($validation->errors()->first());
        }

        $validation->validated();

        $student = Student::whereHas("verifications",function($query)use($request){
            $query->where([
                ["type",'=',VerificationTypeEnums::Password],
                ["code",'=',$request->input("code")],
                ["uses",'=',0],
                ["expired_at",'>',now()],
            ]);
        })->first();

        if (!$student) {
            return failResponse("The code is not valid");
        }

        $student->update([
            "password" => Hash::make($request->input("password")),
        ]);

        $student->verifications()->where([
            ["type",'=',VerificationTypeEnums::Password],
            ["code",'=',$request->input("code")],
            ["uses",'=',0],
        ])->update([
            "uses" => 1,
        ]);

        return successResponse("Done! updated password");
    }

}
