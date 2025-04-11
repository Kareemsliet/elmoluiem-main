<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $table = 'subjects';
    public $timestamps = true;
    protected $fillable = [
        'name',
        "image",
        'education_level_id'
    ];

    public function educationLevel(){
        return $this->belongsTo(EducationLevel::class,"education_level_id");
    }

    public function teachers(){
        return $this->belongsToMany(Teacher::class,"teacher_subject");
    }
}
