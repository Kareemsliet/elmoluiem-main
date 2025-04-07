<?php

namespace App\Models;
use App\Enums\CourseTypesEnums;
use App\Enums\GenderTypesEnums;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\AsEnumCollection;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Teacher extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, Notifiable;
    protected $table = 'teachers';
    public $timestamps = true;
    protected $fillable = [
        'name',
        "email",
        'password',
        'phone',
        "email_verified_at",
        'address',
        "description",
        'profile_image',
        'experince',
        'qualification',
        'cv',
        'course_type',
        "education_level_id",
        "gender",
    ];
    protected $hidden = [
        'password'
    ];
    protected function casts()
    {
        return [
            "password" => "hashed",
            "email_verified_at"=>"datetime",
            "course_type"=>AsEnumCollection::of(CourseTypesEnums::class),
            "gender"=>GenderTypesEnums::class,
        ];
    }

    public function educationLevel(){
        return $this->belongsTo(EducationLevel::class,"education_level_id");
    }

    public function subjects(){
        return $this->belongsToMany(Subject::class,"teacher_subject");
    }

    public function lessons(){
        return $this->hasMany(Lesson::class,"teacher_id");
    }

    public function verifications(){
        return $this->morphMany(Verification::class,"verifiable");
    }

    public function ratings(){
        return $this->morphMany(Rating::class,"rateable",);  
    }

}
