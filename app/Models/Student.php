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
        "email_verified_code",
        "education_level_id",
        'address',
        "email_verified_expired",
        "gender",
        'profile_image'
    ];
    protected $hidden = [
        'password'
    ];
    protected function casts()
    {
        return [
            "email_verified_expired"=>"datetime",
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
}
