<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';

    protected $fillable = [
        'name',
        'description',
        "image",
    ];

    public function subCategories(){
        return $this->hasMany(SubCategory::class, 'category_id');
    }

}
