<?php

namespace App\Http\Controllers\Api\Teacher\Courses;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Teacher\CoursesRequest;
use App\Http\Resources\CourseResource;
use App\Http\Services\ImageService;
use App\Models\Course;

class CoursesController extends Controller
{
     /**
     * Display a listing of the resource.
     */
    protected $teacher;

    public function __construct()
    {
        $this->teacher = auth("teacher")->user();
    }

    public function index()
    {
        $courses = $this->teacher->courses()->orderByDesc("created_at")->get();
        
        return successResponse(data: CourseResource::collection($courses));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CoursesRequest $request)
    {
        $request->validated();

        $data = $request->only(["title", "description", "price","sub_category_id","level"]);

        $image = (new ImageService())->uploadImage($request->file("image"), "teachers/courses");

        $data["image"] = $image;

        $course = $this->teacher->courses()->create($data);

        return successResponse("success add course", new CourseResource($course));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $course = Course::find($id);

        if (!is_numeric($id) || !$course) {
            return failResponse("not found course");
        }

        return successResponse(data: new CourseResource($course));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CoursesRequest $request, string $id)
    {
        $request->validated();

        $course = Course::find($id);

        if (!is_numeric($id) || !$course) {
            return failResponse("not found course");
        }

        $data = $request->only(["title", "description", "price","sub_category_id","level"]);

        if ($request->image) {
            (new ImageService())->destroyImage($course->image, "teachers/courses");

            $image = (new ImageService())->uploadImage($request->file("image"), "teachers/courses");

            $data["image"] = $image;
        }

        $course->update($data);

        return successResponse("success update course", new CourseResource($course));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $course = Course::find($id);

        if (!is_numeric($id) || !$course) {
            return failResponse("not found course");
        }

        (new ImageService())->destroyImage($course->image, "teachers/courses");

        if($course->enrollments->count() > 0){
            return failResponse("you can't delete course, because it has enrollments");
        }

        if ($course->contents->count() > 0) {
            $course->contents()->delete();
        }

        $course->delete();

        return successResponse("success delete course");
    }
}
