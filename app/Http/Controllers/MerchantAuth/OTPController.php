<?php

namespace App\Http\Controllers\MerchantAuth;

use App\Models\Merchant;
use App\Services\Twilio;
use App\Services\Vonage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class OTPController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'max:255'],
        ]);

        $merchant = Merchant::where('email', $request->email)->first();
        if ($merchant) {
            $merchant->generateOTP();
            // send otp to email
            if (config('verification.otp_provider') == 'twilio') {
                (new Twilio())->send($merchant);
            }
            if (config('verification.otp_provider') == 'vonage') {
                (new Vonage())->send($merchant);
            }

            return view('merchant.auth.verify-otp', ['email' => $request->email]);
        } else {
            return back()->with('error', 'Email not found');
        }
    }



    public function verify(Request $request)
    {

        // validate email & otp
        $request->validate([
            'email' => ['required', 'email', 'max:255'],
            'otp' => ['required'],
        ]);

        // check if email exists on database
        $merchant = Merchant::where('email', $request->email)->first();

        // if not exists -> throw validation error
        if (!$merchant) {
            return back()->with('error', 'Email not found');
        }

        // if exists -> send email signed url
        if ($merchant && $merchant->otp == $request->otp) {
            if (now() < $merchant->otp_till) {
                $merchant->resetOTP();
                Auth::guard('merchant')->login($merchant);
                return to_route('merchant.index');
            } else {
                return back()->with('error', 'OTP expired');
            }
        }
    }
}
