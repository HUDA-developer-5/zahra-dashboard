<?php

namespace App\Http\Controllers\Api\User\Auth;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Services\User\UserService;
use Illuminate\Support\Facades\Log;

class LogoutApiController extends Controller
{
    public function logout()
    {
        try {
            (new UserService())->logout(auth('api')->user());
            return ResponseHelper::successResponse([]);
        } catch (\Exception|\TypeError $exception) {
            Log::error($exception->getMessage());
            return ResponseHelper::errorResponse($exception->getMessage());
        }
    }
}
