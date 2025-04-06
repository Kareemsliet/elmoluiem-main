<?php

namespace App\Models;

use App\Enums\VerificationTypeEnums;
use Illuminate\Database\Eloquent\Model;

class Verification extends Model
{
    protected $table = 'verifications';

    protected $fillable= [
        'code',
        'expired_at',
        'uses',
        "type",
    ];

    protected $casts = [
        'expired_at' => 'datetime',
        "type"=>VerificationTypeEnums::class,
    ];

    public function verifiable()
    {
        return $this->morphTo();
    }

}
