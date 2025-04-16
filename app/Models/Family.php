<?php

namespace App\Models;
use App\Enums\GenderTypesEnums;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Musonza\Chat\Models\Conversation;
use Musonza\Chat\Traits\Messageable;

class Family extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, Notifiable,Messageable;
    protected $table = 'familes';
    public $timestamps = true;
    protected $fillable = [
        'name',
        'password',
        'email',
        "email_verified_at",
        'phone',
        "gender",
        'education_level_id',
        "description",
        'profile_image',
    ];
    protected $hidden = ['password'];

    protected function casts()
    {
        return [
            "email_verified_at"=>"datetime",
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

    public function verifications(){
        return $this->morphMany(Verification::class,"verifiable");
    }

    public function teacherRatings(){
        return $this->morphToMany(Teacher::class,"rateable","teacher_ratings")->withPivot("rate","description")->withTimestamps();  
    }
    public function hiddenConversations(){
        return $this->morphToMany(Conversation::class,"messageable","hidden_conversation")->withTimestamps();
    }
}
