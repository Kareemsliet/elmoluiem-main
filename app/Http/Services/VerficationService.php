<?php

namespace App\Http\Services;

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

        $user->update([
            "email_verified_code" => $code,
            "email_verified_expired"=>now()->addHour(),
        ]);

        Mail::to($user)->send(new SendEmailVerificationCode($code));
    }

    public function sendResetPasswordVerificationCode($user)
    {
        $code = $this->generateCode();

        $user->update([
            "reset_password_code" => $code,
            "reset_password_expired"=>now()->addHour(),
        ]);

        Mail::to($user)->send(new PasswordResetVerification($code));
    }

}
