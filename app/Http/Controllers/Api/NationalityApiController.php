<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\NationalityApiResource;
use App\Services\NationalityService;
use Illuminate\Support\Facades\Log;

class NationalityApiController extends Controller
{
    public function index()
    {
        try {
            return ResponseHelper::successResponse(
                data: [
                    'nationalities' => NationalityApiResource::collection((new NationalityService())->listNationalities())
                ]
            );
        } catch (\Exception|\TypeError $exception) {
            Log::error($exception->getMessage());
            return ResponseHelper::errorResponse(error: trans('api.something went wrong'));
        }
    }
}
