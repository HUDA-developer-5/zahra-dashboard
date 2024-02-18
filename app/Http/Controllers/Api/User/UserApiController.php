<?php

namespace App\Http\Controllers\Api\User;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\Auth\ChangePasswordApiRequest;
use App\Http\Requests\Api\User\Auth\UpdateUserProfileApiRequest;
use App\Http\Resources\Api\User\UserApiResource;
use App\Services\User\UserService;
use Illuminate\Support\Facades\Log;

class UserApiController extends Controller
{
    public function getProfile()
    {
        try {
            $user = auth('api')->user();
            return ResponseHelper::successResponse(
                data: [
                    'user' => UserApiResource::make($user)
                ]
            );
        } catch (\Exception|\TypeError $exception) {
            Log::error($exception->getMessage());
            return ResponseHelper::errorResponse(error: trans('api.something went wrong'));
        }
    }

    public function changePassword(ChangePasswordApiRequest $request)
    {
        try {
            $user = auth('api')->user();
            if ((new UserService())->changePassword($user, $request->get('old_password'), $request->get('new_password'))) {
                return ResponseHelper::successResponse(data: [], message: trans('api.your password updated successfully'));
            }
            return ResponseHelper::errorResponse(error: trans('api.Invalid old password'));
        } catch (\Exception|\TypeError $exception) {
            Log::error($exception->getMessage());
            return ResponseHelper::errorResponse(error: trans('api.something went wrong'));
        }
    }

    public function update(UpdateUserProfileApiRequest $request)
    {
        try {
            $user = auth('api')->user();
            $user = (new UserService())->updateProfile($user, $request->getDTO());
            return ResponseHelper::successResponse(data: ['user' => UserApiResource::make($user)]);
        } catch (\Exception|\TypeError $exception) {
            Log::error($exception->getMessage());
            return ResponseHelper::errorResponse(error: trans('api.something went wrong'));
        }
    }

    public function deleteAccount()
    {
        try {
            $user = auth('api')->user();
            (new UserService())->deleteAccount($user);
            return ResponseHelper::successResponse(data: [], message: trans('api.your account deleted successfully'));
        } catch (\Exception|\TypeError $exception) {
            Log::error($exception->getMessage());
            return ResponseHelper::errorResponse(error: trans('api.something went wrong'));
        }
    }
}
