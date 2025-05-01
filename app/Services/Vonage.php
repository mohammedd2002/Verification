<?php

namespace App\Services;

use Vonage\Client;
use Vonage\SMS\Message\SMS;
use Vonage\Client\Credentials\Basic;


class Vonage
{
    public function send($merchant)
    {
        $basic  = new Basic(env('VONAGE_API_KEY'), env('VONAGE_API_SECRET'));
        $client = new Client($basic);
        $response = $client->sms()->send(
            new SMS($merchant->phone, env('APP_NAME'), "Your OTP is $merchant->otp")
        );
    }
}
