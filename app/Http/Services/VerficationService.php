<?php

namespace App\Http\Services;

use App\Enums\VerificationTypeEnums;
use App\Mail\PasswordResetVerification;
use App\Mail\SendEmailVerificationCode;
use Illuminate\Support\Facades\Mail;
class VerficationService
{
    public function generateCode()
    {
        $code = rand(111111, 999999);
        
        return $code;
    }
    public function sendEmailVerificationCode($user)
    {
        $code = $this->generateCode();

        if($user->verifications->count() > 0 ){
            $user->verifications()->where("uses",'=',0)->get()->map(function ($verification) {
                $verification->update([
                    "uses"=>1,
                ]);
            });
        }

        $user->verifications()->create([
            "code"=>$code,
            "expired_at"=>now()->addHour(),
            "type"=>VerificationTypeEnums::Email,
        ]);

        Mail::to($user)->send(new SendEmailVerificationCode($code));
    }

    public function sendResetPasswordVerificationCode($user)
    {
        $code = $this->generateCode();

        if($user->verifications->count() > 0 ){
            $user->verifications()->where("uses",'=',0)->get()->map(function ($verification) {
                $verification->update([
                    "uses"=>1,
                ]);
            });
        }

        $user->verifications()->create([
            "code"=>$code,
            "expired_at"=>now()->addHour(),
            "type"=>VerificationTypeEnums::Password,
        ]);

        Mail::to($user)->send(new PasswordResetVerification($code));
    }

}
