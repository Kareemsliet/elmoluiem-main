<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model 
{
    protected $table = 'countries';
    public $timestamps = true;
    protected $fillable = array('name',"code");

    public function educationSystems()
    {
        return $this->hasMany(EducationSystem::class,"country_id");
    }

}