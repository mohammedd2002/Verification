<?php

namespace App\Http\Controllers\MerchantAuth;

use App\Models\Merchant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PasswordlessEmailController extends Controller
{
    public function store(Request $request){
        $request->validate([
            'email' => ['required', 'email' , 'max:255'],
        ]);

        $merchant = Merchant::where('email', $request->email)->first();
        if($merchant){
            $merchant->sendEmailVerificationNotification();
            return back()->with('success', 'Email sent');
        }else{
            return back()->with('error', 'Email not found');
        }

    }

    public function verify(Request $request){
        Auth::guard('merchant')->loginUsingId($request->id);
        return redirect()->route('merchant.index');
    }
}
