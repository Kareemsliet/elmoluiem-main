<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = 'transactions';

    protected $fillable = [
        "total",
        "teacher_id",
        "commission",
        "teacher_amount",
        "commission_amount"
    ];

    public function teacher(){
        return $this->belongsTo(Teacher::class,"teacher_id");
    }

    protected function casts(){
        return [
            "commission"=> "decimal",
            "total"=> "decimal",
            "teacher_amount"=> "decimal",
            "commission_amount"=> "decimal",
        ];
    }
}
