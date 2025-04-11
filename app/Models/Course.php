<?php

namespace App\Models;

use App\Enums\CourseLevelsEnums;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $table = 'courses';

    protected $fillable = [
        'name',
        'description',
        'sub_category_id',
        'image',
        'price',
        'level',
    ];

    protected function casts(){
        return [
            "level"=>CourseLevelsEnums::class,
        ];
    }

    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class, 'sub_category_id');
    }

    public function contents(){
        return $this->morphMany(Content::class, 'contentable');
    }

    public function enrollments(){
        return $this->morphToMany(Student::class, 'enrollmentable', 'enrollmentables')->withTimestamps();
    }

    public function orders(){
        return $this->morphMany(Order::class,"orderable");
    }

}
