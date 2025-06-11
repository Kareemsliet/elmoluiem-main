<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    protected $table = 'quizzes';

    protected $fillable = [
        'title',
        'subject_id',
        'education_level_id',
        'academic_year',
        'start_time',
        'end_time',
        'time_limit',
        'date'
    ];

    public function subject()
    {
        return $this->belongsTo(Subject::class,"subject_id");
    }

    public function educationLevel()
    {
        return $this->belongsTo(EducationLevel::class,'education_level_id');
    }

    public function questions()
    {
        return $this->hasMany(Question::class, 'quiz_id');
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }

}
