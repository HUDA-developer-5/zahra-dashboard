<?php

namespace App\Http\Controllers\Api\User\Auth;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\Auth\ForgetPasswordApiRequest;
use App\Http\Requests\Api\User\Auth\ResetPasswordApiRequest;
use App\Services\User\UserResetPasswordService;
use App\Services\User\UserService;
use Illuminate\Support\Facades\Log;

class PasswordResetTokenAPIController extends Controller
{
    public function sendResetLink(ForgetPasswordApiRequest $request)
    {
        try {
            $user = (new UserService())->findByEmail($request->get('email'));
            if (!$user) {
                return ResponseHelper::errorResponse(trans('api.invalid email'));
            }
            (new UserResetPasswordService())->sendEmail($user->email);
            return ResponseHelper::successResponse(data: []);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return ResponseHelper::errorResponse(trans('api.something went wrong'));
        }
    }

    public function showResetPasswordPage($token)
    {
        $record = (new UserResetPasswordService())->getTokenRecord($token);
        if (!$record) {
            return "Invalid Token";
        }
        return view("reset_password")->with(['token' => $token]);
    }

    public function resetPassword(ResetPasswordApiRequest $request)
    {
        $userResetPasswordService = new UserResetPasswordService();
        // get record
        $record = $userResetPasswordService->getTokenRecord($request->get('token'));
        if (!$record) {
            return "invalid token";
        }
        // reset user password
        $userService = new UserService();
        $user = $userService->findByEmail($record->email);
        if (!$user) {
            return "User not Valid";
        }
        // reset user password
        $user = $userService->updatePassword($user, $request->get('password'));
        // remove reset token record
        $userResetPasswordService->deleteRecord($request->get('token'));
        return "Your password changed successfully";
    }
}
