<?php

namespace App\Http\Controllers\Api\Family;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Family\LoginRequest;
use App\Http\Requests\Api\Family\PasswordUpdateRequest;
use App\Http\Requests\Api\Family\ProfileUpdateRequest;
use App\Http\Requests\Api\Family\RegisterRequest;
use App\Http\Resources\FamilyResource;
use App\Http\Services\ImageService;
use App\Http\Services\VerficationService;
use App\Models\Family;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $request->validated();

        $parent = Family::where("email", '=', $request->input("email"))->first();

        if (!$parent) {
            return failResponse(__("auth.failed"));
        }

        if (!Hash::check($request->password, $parent->password)) {
            return failResponse(__("auth.failed"));
        }

        if ($parent->tokens->count() > 0) {
            $parent->tokens()->delete();
        }

        $token = $parent->createToken("family")->plainTextToken;

        return successResponse("success login", [
            "token" => $token,
        ]);
    }

    public function register(RegisterRequest $request)
    {
        $request->validated();

        $data = $request->only(["name", "email", "password", "phone", 'education_level_id', "gender"]);

        $family = Family::create($data);

        $students = Student::whereIn("phone", $request->students)->get()->pluck("id")->toArray();

        $family->students()->sync($students);

        $token = $family->createToken("family")->plainTextToken;

        (new VerficationService())->sendEmailVerificationCode($family);

        return successResponse("success register", [
            "token" => $token,
        ]);
    }

    public function logout(Request $request)
    {
        $parent = $request->user("family");

        $parent->currentAccessToken()->delete();

        return successResponse("success logout");
    }

    public function updatePassword(PasswordUpdateRequest $request)
    {
        $request->validated();

        $parent = Family::where("email", '=', $request->input("email"))->first();

        $parent->update([
            "password" => $request->input("password"),
        ]);

        return successResponse("Done! updated password");
    }

    public function verifyCode(Request $request)
    {

        $validation = validator($request->only(["code"]), [
            "code" => "required|numeric|exists:familes,email_verified_code",
        ]);

        if ($validation->fails()) {
            return failResponse($validation->errors()->first());
        }

        $validation->validated();

        $family = Family::where("email_verified_code", '=', $request->input("code"))->first();

        if (!now()->isBefore($family->email_verified_expired)) {
            return failResponse("The code is expired");
        }

        $family->update([
            "email_verified_at" => now(),
        ]);

        return successResponse("Success Verification Email");
    }

    public function profile(Request $request)
    {
        $family = $request->user("family");

        return successResponse(data: new FamilyResource($family));
    }

    public function updateProfile(ProfileUpdateRequest $request)
    {
        $request->validated();

        $family = $request->user("family");

        $data = $request->only(["name", "email", 'phone', "education_level_id", "gender", "description"]);

        if ($request->profile_image) {
            if ($family->profile_image) {
                (new ImageService())->destroyImage($family->profile_image, "familes");
            }
            $data["profile_image"] = (new ImageService())->uploadImage($request->file("profile_image"), "familes");
        }

        if ($data["email"] != $family->email) {

            $data["email_verified_at"] = null;

            (new VerficationService())->sendEmailVerificationCode($family);
        }

        $family->update($data);

        $students = Student::whereIn("phone", $request->students)->get()->pluck("id")->toArray();

        $family->students()->sync($students);

        return successResponse(data: new FamilyResource($family));
    }

}
