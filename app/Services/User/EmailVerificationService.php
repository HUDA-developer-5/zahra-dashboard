<?php

namespace App\Services\User;

use App\Helpers\GlobalHelper;
use App\Models\EmailVerification;
use App\Models\User;

class EmailVerificationService
{
    public function verify($token): bool
    {
        $verificationRecord = $this->getVerificationTokenRecord($token);
        if ($verificationRecord) {
            // update join request
            $joinRequest = JoinRequest::where('email', '=', $verificationRecord->email)->first();
            if ($joinRequest && !$joinRequest->email_verified_at) {
                $joinRequest->update(['email_verified_at' => now()]);
            }
            // update user
            $user = User::where('email', '=', $verificationRecord->email)->first();
            if ($user && !$user->email_verified_at) {
                $user->update(['email_verified_at' => now()]);
            }
            return true;
        }
        return false;
    }

    public function sendVerificationEmail(string $email): void
    {
        $token = $this->generateUniqueVerificationToken();
        $this->saveVerificationToken($email, $token);
        // Send email
//        Mail::to($email)->send(new SendEmailVerification($token));
        $language = GlobalHelper::getDefaultLanguage();
        (new SendgridService())->sendEmail(SendgridSendEmailDTO::from([
            'subject' => trans('api_v1.email.verification_subject'),
            'to' => $email,
            'toName' => trans('api_v1.email.default_user_name'),
            'view' => view('email.verify_'.$language->value)->with(['verificationLink' => (new EmailVerificationService())->getVerificationTokenLink($token)]),
        ]));
    }

    public function getVerificationTokenLink(string $token): string
    {
        return route('verify_email', ['token' => $token]);
    }

    protected function saveVerificationToken(string $email, string $token): void
    {
        EmailVerification::updateOrCreate(
            [
                'email' => $email,
            ],
            [
                'token' => $token
            ]
        );
    }

    protected function generateUniqueVerificationToken(): string
    {
        do {
            $token = $this->generateToken();
        } while ($this->getVerificationTokenRecord($token));
        return $token;
    }

    protected function generateToken(): string
    {
        return bin2hex(random_bytes(32));
    }

    protected function getVerificationTokenRecord($token)
    {
        return EmailVerification::where('token', '=', $token)->first();
    }
}