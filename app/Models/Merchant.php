<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Notifications\EmailVerificationNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;



class Merchant extends Authenticatable implements MustVerifyEmail
{

    public function sendEmailVerificationNotification()
    {
        if (config('verification.way') == 'email') {
            $url = URL::temporarySignedRoute(
                'merchant.verification.verify',
                now()->addMinutes(30),
                ['id' => $this->id, 'hash' => sha1($this->email),]
            );
            $this->notify(new EmailVerificationNotification($url));
        }

        if (config('verification.way') == 'cvt') {
            $this->generateVerificationToken();
            $url = route('merchant.verification.verify', ['id' => $this->id, 'token' => $this->verification_token]);
            $this->notify(new EmailVerificationNotification($url));
        }

        if (config('verification.way') == 'passwordless') {
            $url = URL::temporarySignedRoute(
                'merchant.verification.verify',
                now()->addMinutes(30),
                ['id' => $this->id, ]
            );
            $this->notify(new EmailVerificationNotification($url));
        }
    }

    public function generateVerificationToken()
    {
        if (config('verification.way') == 'cvt') {
            $this->verification_token = Str::random(40);
            $this->verification_token_till = now()->addMinutes(30);
            $this->save();
        }
    }

    public function emailVerified(){
        if (config('verification.way') == 'cvt') {
            $this->email_verified_at = now();
            $this->verification_token = null;
            $this->verification_token_till = null;
            $this->save();
        }
    }

    public function generateOTP()
    {
        if (config('verification.way') == 'otp') {
            $this->otp = rand(111111, 999999);
            $this->otp_till = now()->addMinutes(30);
            $this->save();
        }
    }

    public function resetOTP()
    {
        if (config('verification.way') == 'otp') {
            $this->otp = null;
            $this->otp_till = null;
            $this->save();
        }
    }


    use HasFactory, Notifiable;

    protected $guarded = ['id'];
}
