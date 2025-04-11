<?php

namespace App\Models;

use App\Enums\PaymentStatusEnums;
use Illuminate\Database\Eloquent\Model;

class Payout extends Model
{
    protected $table = 'payouts';
    protected $fillable = [
        'teacher_id',
        'amount',
        'status',
        'transaction_id',
    ];

    protected function casts(){
        return [
            "amount"=> "decimal",
            "status"=> PaymentStatusEnums::class,
        ];
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class,"teacher_id");
    }

}
