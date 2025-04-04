<?php

namespace App\Models;

use App\Enums\TeacherTypeEnums;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model 
{
    protected $table = 'lessons';
    public $timestamps = true;
    protected $fillable = array('teacher_id','price','title','logo','description');

    public function teacher()
    {
        return $this->belongsTo(Teacher::class,"teacher_id");
    }

    public function contents(){
        return $this->morphMany(Content::class,"contentable");
    }

}