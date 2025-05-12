<?php

namespace App\Http\Controllers\Api;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\CourseResource;
use App\Http\Resources\EducationSystemResource;
use App\Http\Resources\FamilyResource;
use App\Http\Resources\LessonReource;
use App\Http\Resources\SearchableResource;
use App\Http\Resources\StudentResource;
use App\Http\Resources\SubCategoryResource;
use App\Http\Resources\SubjectResource;
use App\Http\Resources\TeacherResource;
use App\Http\Services\VerficationService;
use App\Models\Category;
use App\Models\Country;
use App\Http\Controllers\Controller;
use App\Models\EducationLevel;
use App\Models\EducationSystem;
use App\Http\Resources\CountryResource;
use App\Http\Resources\EducationLevelResource;
use App\Models\Family;
use App\Models\Student;
use App\Models\SubCategory;
use App\Models\Teacher;
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
        $exceptId = $request->query("exceptId", null);

        $excepts = [];

        $search = $request->query("q", "");

        $subCategory = SubCategory::find($subCategory_id);

        if (!is_numeric($subCategory_id) || !$subCategory) {
            return failResponse("not found sub category");
        }

        if ($exceptId) {
            $excepts[] = $exceptId;
        }

        $courses = $subCategory->courses()->where("courses.title", 'like', "%$search%")->orderByDesc("created_at")->offset(0)->limit(6)->get()->except($excepts);

        return successResponse(data: CourseResource::collection($courses));
    }

    public function teacherDetails($teacher_id)
    {

        $teacher = Teacher::find($teacher_id);

        if (!is_numeric($teacher_id) || !$teacher) {
            return failResponse("not found teacher");
        }

        return successResponse(data: new TeacherResource($teacher));
    }

    public function teacherLessons(Request $request, $teacher_id)
    {
        $exceptId = $request->query("exceptId", null);

        $excepts = [];

        if ($exceptId) {
            $excepts[] = $exceptId;
        }

        $teacher = Teacher::find($teacher_id);

        if (!$teacher || !is_numeric($teacher_id)) {
            return failResponse("not found teacher");
        }

        $lessons = $teacher->lessons()->orderByDesc("created_at")->limit(6)->get()->except($excepts);

        return successResponse(data: LessonReource::collection($lessons));
    }

    public function studentDetails($student_id)
    {
        $student = Student::find($student_id);

        if (!is_numeric($student_id) || !$student) {
            return failResponse("not found student");
        }

        return successResponse(data: new StudentResource($student));
    }

    public function familyDetails($family_id)
    {
        $family = Family::find($family_id);

        if (!is_numeric($family_id) || !$family) {
            return failResponse("not found parent");
        }

        return successResponse(data: new FamilyResource($family));
    }

    public function search(Request $request)
    {
        $limit = $request->query("limit", 5);

        $search = $request->query("q", "");

        $users = collect([Student::all(), Teacher::all(), Family::all()])
            ->flatten()
            ->when(function () use ($search) {
                return !empty($search);
            }, function ($collection) use ($search) {
                $pattern = str_replace('%', '.*', preg_quote($search, '/'));
                $pattern = str_replace('_', '.', $pattern);
                $regex = "/^{$pattern}$/i"; 
                return $collection->filter(function ($item) use ($regex) {
                    return preg_match($regex, $item['name']) ||
                        preg_match($regex, $item['email']) ||
                        preg_match($regex, $item['phone']);
                });
            })
            ->take($limit);

        return successResponse(data: SearchableResource::collection($users));
    }

}
