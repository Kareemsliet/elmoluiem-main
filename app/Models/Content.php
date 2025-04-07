<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    protected $table="contents";

    protected $fillable=["title","description"];

    public function contentable(){
        return $this->morphTo();
    }
    public function lectures(){
        return $this->hasMany(Lecture::class,"content_id");
    }
}
