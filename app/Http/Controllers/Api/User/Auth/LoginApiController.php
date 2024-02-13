<?php

namespace App\Http\Controllers\Api\User\Auth;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\Auth\UserLoginApiRequest;
use App\Http\Resources\Api\User\AccessTokenApiResource;
use App\Http\Resources\Api\User\UserApiResource;
use App\Services\User\UserLoginService;
use Illuminate\Support\Facades\Log;

class LoginApiController extends Controller
{
    public function login(UserLoginApiRequest $request)
    {
        try {
            $user = (new UserLoginService())->login($request->get('user_name'), $request->get('password'));
            if (!$user){
                return ResponseHelper::errorResponse(trans('api.login.invalid credentials'));
            }
            $accessToken = $user->createAccessToken($user);
            return ResponseHelper::successResponse(data: [
                'user' => UserApiResource::make($user),
                'access_token' => new AccessTokenApiResource($accessToken)
            ]);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return ResponseHelper::errorResponse(trans('api.something went wrong'));
        }
    }
}
