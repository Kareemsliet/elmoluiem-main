<?php

namespace App\Http\Controllers\Api;
use App\Http\Resources\EducationSystemResource;
use App\Http\Resources\SubjectResource;
use App\Http\Services\VerficationService;
use App\Models\Country;
use App\Http\Controllers\Controller;
use App\Models\EducationLevel;
use App\Models\EducationSystem;
use App\Http\Resources\CountryResource;
use App\Http\Resources\EducationLevelResource;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function countries()
    {
        return successResponse(data: CountryResource::collection(Country::all()));
    }


    public function educationsystems($country_id)
    {
        $country = Country::find($country_id);

        if (!is_numeric($country_id) || !$country) {
            return failResponse("not found country");
        }

        $educationSystems = $country->educationSystems;

        return successResponse(data: EducationSystemResource::collection($educationSystems));
    }


    public function educationlevels($educationSystem_id)
    {
        $educationSystem = EducationSystem::find($educationSystem_id);

        if (!is_numeric($educationSystem_id) || !$educationSystem) {
            return failResponse("not found education system");
        }

        $educationLevels = $educationSystem->educationLevels;

        return successResponse(data: EducationLevelResource::collection($educationLevels));
    }


    public function subjects($educationLevel_id)
    {
        $educationLevel = EducationLevel::find($educationLevel_id);

        if (!is_numeric($educationLevel_id) || !$educationLevel) {
            return failResponse("not found education system level");
        }

        $subjects = $educationLevel->subjects;

        return successResponse(data: SubjectResource::collection($subjects));
    }

    public function checkAuth(Request $request)
    {
        if ($request->user("sanctum")) {

            $role="";

            if (auth("student")->check()) {
                $role = "student";
            }

            if (auth("teacher")->check()) {
                $role = "teacher";
            }

            if (auth("family")->check()) {
                $role = "parent";
            }

            return successResponse(data: [
                "auth" => true,
                "email-verified" => $request->user("sanctum")->hasVerifiedEmail(),
                "role" => $role,
            ]);

        } else {
            return successResponse(data: [
                "auth" => false,
            ]);
        }
    }

    public function sendVerificationCode(Request $request)
    {
        $user = $request->user("sanctum");
        
        (new VerficationService())->sendEmailVerificationCode($user);

        return successResponse("Success Send  verification Code at your email box");
    }
}
