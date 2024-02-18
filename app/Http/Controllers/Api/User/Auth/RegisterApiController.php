<?php

namespace App\Http\Controllers\Api\User\Auth;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\Auth\UserRegisterApiRequest;
use App\Http\Resources\Api\User\AccessTokenApiResource;
use App\Http\Resources\Api\User\UserApiResource;
use App\Services\User\UserRegisterService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RegisterApiController extends Controller
{
    public function register(UserRegisterApiRequest $request)
    {
        try {
            DB::beginTransaction();
            $user = (new UserRegisterService())->store($request->getDTO());
            $accessToken = $user->createAccessToken($user);
            DB::commit();
            return ResponseHelper::successResponse(data: [
                'user' => UserApiResource::make($user),
                'access_token' => new AccessTokenApiResource($accessToken)
            ]);
        } catch (\Exception|\TypeError $exception) {
            DB::rollBack();
            Log::error($exception->getMessage());
            return ResponseHelper::errorResponse(error: trans('api.something went wrong'));
        }
    }
}
