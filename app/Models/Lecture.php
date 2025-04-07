<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lecture extends Model
{
    protected $table="lectures";

    protected $fillable=["title","description","content_id","deuration","video"];
    
    public function content(){
        return $this->belongsTo(Content::class,"content_id");
    }
}
