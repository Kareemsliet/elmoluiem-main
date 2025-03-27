<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EducationSystem extends Model 
{
    protected $table = 'education_systems';
    public $timestamps = true;
    protected $fillable = array('name', 'country_id');
    public function country()
    {
        return $this->belongsTo(Country::class,"country_id");
    }

    public function educationLevels(){
        return $this->hasMany(EducationLevel::class,"education_system_id");
    }

}