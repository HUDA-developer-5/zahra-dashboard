<?php

namespace App\Services\User;

use App\Mail\ResetPasswordMail;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class UserResetPasswordService
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

    public function sendEmail(string $email): void
    {
        $token = $this->generateUniqueToken();
        $this->saveToken($email, $token);
        // Send email
        @Mail::to($email)->send(new ResetPasswordMail($this->getLink($token)));
    }

    public function getLink(string $token): string
    {
        return route('reset_password', ['token' => $token]);
    }

    protected function saveToken(string $email, string $token): void
    {
        DB::table('password_reset_tokens')->insert([
            'email' => $email,
            'token' => $token
        ]);
    }

    protected function generateUniqueToken(): string
    {
        do {
            $token = $this->generateToken();
        } while ($this->getTokenRecord($token));
        return $token;
    }

    protected function generateToken(): string
    {
        return bin2hex(random_bytes(32));
    }

    public function getTokenRecord($token)
    {
        return DB::table('password_reset_tokens')->where('token', '=', $token)->first();
    }

    public function deleteRecord($token)
    {
        return DB::table('password_reset_tokens')->where('token', '=', $token)->delete();
    }
}