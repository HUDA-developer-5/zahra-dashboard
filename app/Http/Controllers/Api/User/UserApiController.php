<?php

namespace App\Http\Controllers\Api\User;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\User\UserApiResource;
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
            return ResponseHelper::errorResponse($exception->getMessage());
        }
    }
}
