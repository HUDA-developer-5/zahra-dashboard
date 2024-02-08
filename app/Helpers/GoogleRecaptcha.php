<?php

namespace App\Helpers;


use Illuminate\Http\Request;

class GoogleRecaptcha
{
    public function validateGoogleCaptcha($recaptchaResponse): bool
    {
        $secret = config('services.google.recaptcha.secret_key');
        $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $secret . '&response=' . $recaptchaResponse);
        $responseData = json_decode($verifyResponse);
        if ($responseData && $responseData->success && $responseData->score > 0.5) {
            return true;
        }
        return false;
    }

    public function check(Request $request): bool
    {
        if ($request->has('g-recaptcha-response') && $request->filled("g-recaptcha-response")) {
            return $this->validateGoogleCaptcha($request->get('g-recaptcha-response'));
        }
        return false;
    }
}
