<?php

namespace App\Http\Controllers\Api;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\CourseResource;
use App\Http\Resources\EducationSystemResource;
use App\Http\Resources\SubCategoryResource;
use App\Http\Resources\SubjectResource;
use App\Http\Services\VerficationService;
use App\Models\Category;
use App\Models\Country;
use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\EducationLevel;
use App\Models\EducationSystem;
use App\Http\Resources\CountryResource;
use App\Http\Resources\EducationLevelResource;
use App\Models\SubCategory;
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

            $role = "";

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

    public function categories()
    {
        $categories = Category::orderByDesc("created_at")->get();

        return successResponse(data: CategoryResource::collection($categories));
    }

    public function subCategories($category_id)
    {
        $category = Category::find($category_id);

        if (!is_numeric($category_id) || !$category) {
            return failResponse("not found category");
        }

        $subCategories = $category->subCategories()->orderByDesc("created_at")->get();

        return successResponse(data: SubCategoryResource::collection($subCategories));
    }

    public function courses(Request $request, $subCategory_id)
    {

        $search = $request->query("q", "");

        $subCategory = SubCategory::find($subCategory_id);

        if (!is_numeric($subCategory_id) || !$subCategory) {
            return failResponse("not found sub category");
        }

        $courses = $subCategory->courses()->where("courses.title", 'like', "%$search%")->orderByDesc("created_at")->get();

        return successResponse(data: CourseResource::collection($courses));
    }

    public function allCourses(Request $request)
    {
        $search = $request->query("q", "");

        $courses = Course::where("title", 'like', "%$search%")->orderByDesc("created_at")->offset(0)->limit(10)->get();

        return successResponse(data: CourseResource::collection($courses));
    }

}
