<?php

namespace App\Models;

use App\Enums\PaymentStatusEnums;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';

    protected $fillable = [
        'student_id',
        'amount',
        "paymob_order_id",
        'transaction_id',
        'status'
    ];

    protected function casts(){
        return [
            "status"=>PaymentStatusEnums::class,
        ];
    }

    public function student()
    {
        return $this->belongsTo(Student::class,"student_id");
    }

    public function orderable(){
        return $this->morphTo();
    }
}
