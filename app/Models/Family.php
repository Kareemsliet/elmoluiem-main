<?php

namespace App\Models;
use App\Enums\GenderTypesEnums;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Family extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, Notifiable;
    protected $table = 'familes';
    public $timestamps = true;
    protected $fillable = [
        'name',
        'password',
        'email',
        "email_verified_at",
        "email_verified_code",
        'phone',
        "gender",
        "email_verified_expired",
        'education_level_id',
        "description",
        'profile_image'
    ];
    protected $hidden = ['password'];

    protected function casts()
    {
        return [
            "email_verified_at"=>"datetime",
            "email_verified_expired"=>"datetime",
            "password" => "hashed",
            "gender"=>GenderTypesEnums::class,
        ];
    }

    public function educationLevel(){
        return $this->belongsTo(EducationLevel::class,"education_level_id");
    }

    public function students(){
        return $this->belongsToMany(Student::class,"family_student");
    }

}
