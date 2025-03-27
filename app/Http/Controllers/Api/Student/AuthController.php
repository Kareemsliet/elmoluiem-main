<?php

namespace App\Http\Controllers\Api\Student;

use App\Http\Resources\StudentResource;
use App\Http\Services\VerficationService;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Student\LoginRequest;
use App\Http\Requests\Api\Student\RegisterRequest;
use App\Http\Requests\Api\Student\UpdatePasswordRequest;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $request->validated();

        $student = Student::where("email", '=', $request->input("email"))->first();

        if(!$student){
            return failResponse(__("auth.failed"));
        }

        if(!Hash::check($request->password,$student->password)){
            return failResponse(__("auth.failed"));
        }

        if($student->tokens->count() > 0 ){
            $student->tokens()->delete();
        }

        $token = $student->createToken("student")->plainTextToken;

        return successResponse("success login",[
            "token" => $token,
        ]);
    }

    public function register(RegisterRequest $request)
    {
        $request->validated();

        $data=$request->only(["name","email","password","address",'phone',"education_level_id","gender"]);

        $student=Student::create($data);

        $token = $student->createToken("student")->plainTextToken;

        (new VerficationService())->sendEmailVerificationCode($student);

        return successResponse("success register done",[
            "token" => $token,
        ]);
    }

    public function logout(Request $request)
    {
        $student=$request->user("student");

        $student->currentAccessToken()->delete();

        return successResponse("success logout");
    }

    public function updatePassword(UpdatePasswordRequest $request)
    {
        $request->validated();

        $student=Student::where("email",'=',$request->input("email"))->first();

        $student->update([
            "password"=>$request->input("password"),
        ]);

        return successResponse("Done! updated password");
    }

    public function verifyCode(Request $request){
        
        $validation=validator($request->only(["code"]),[
            "code"=>"required|numeric|exists:students,email_verified_code",
        ]);

        if($validation->fails()){
            return failResponse($validation->errors()->first());
        }

        $validation->validated();

        $student=Student::where("email_verified_code",'=',$request->input("code"))->first();

        if(!now()->isBefore($student->email_verified_expired)){
            return failResponse("The code is expired");
        }

        $student->update([
            "email_verified_at"=>now(),
        ]);

        return successResponse("Success Verification Email");
    }

}
