<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EducationLevel extends Model
{
    protected $table = 'education_levels';

    protected $fillable = [
        'name',
        "description",
        'education_system_id',
    ];

    public function educationSystem()
    {
        return $this->belongsTo(EducationSystem::class,"education_system_id");
    }

    public function teachers(){
        return $this->hasMany(Teacher::class,"education_level_id");
    }

    public function students(){
        return $this->hasMany(Student::class,"education_level_id");
    }

    public function familes(){
        return $this->hasMany(Family::class,"education_level_id");
    }

    public function subjects(){
        return $this->hasMany(Subject::class,"education_level_id");
    }

}
