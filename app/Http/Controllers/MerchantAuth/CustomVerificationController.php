<?php

namespace App\Http\Controllers\MerchantAuth;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\MerchantEmailVerificationRequest;
use App\Models\Merchant;

class CustomVerificationController extends Controller
{
    /**
     * Display the email verification prompt.
     */
    public function notice(Request $request)
    {
        return $request->user('merchant')->hasVerifiedEmail()
                    ? to_route('merchant.index')
                    : view('merchant.auth.verify-email');
    }


    public function verify(Request $request)
    {
        $merchant = Merchant::where('verification_token', $request->token)->firstOrFail();
        if (now() < $merchant->verification_token_till) {
           $merchant->emailVerified();
           return to_route('merchant.index');
        }
        abort(401);
    }

    public function resend(Request $request): RedirectResponse
    {
        if ($request->user('merchant')->hasVerifiedEmail()) {
            return to_route('merchant.index');
        }

        $request->user('merchant')->sendEmailVerificationNotification();

        return back()->with('status', 'verification-link-sent');
    }
}
