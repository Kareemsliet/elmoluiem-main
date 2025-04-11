<?php

namespace App\Models;
use App\Enums\GenderTypesEnums;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
class Student extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens;
    protected $table = 'students';
    public $timestamps = true;
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        "email_verified_at",
        "description",
        "education_level_id",
        'address',
        "gender",
        'profile_image',
    ];
    protected $hidden = [
        'password'
    ];
    protected function casts()
    {
        return [
            "password" => "hashed",
            "gender"=>GenderTypesEnums::class,
        ];
    }


    public function educationLevel(){
        return $this->belongsTo(EducationLevel::class,"education_level_id");
    }

    public function familes(){
        return $this->belongsToMany(Family::class,"family_student");
    }

    public function subjects(){
       return $this->belongsToMany(Subject::class,"subject_student","student_id","subject_id")->withTimestamps();
    }

    public function verifications(){
        return $this->morphMany(Verification::class,"verifiable");
    }

    public function teacherRatings(){
        return $this->morphToMany(Teacher::class,"rateable","teacher_ratings")->withPivot("rate","description")->withTimestamps();  
    }

    public function teacherRatingsAboutMe(){
        return $this->morphedByMany(Teacher::class,"rateable","student_rating")->withPivot("rate","description")->withTimestamps();
    }

   public function orders(){
     return $this->hasMany(Order::class,"student_id");
   }
    public function enrollingLessons(){
        return $this->morphedByMany(Lesson::class,"enrollmentable","enrollmentables")->withTimestamps();
    }
}
