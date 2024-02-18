<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\CountryApiResource;
use App\Services\CountryService;
use Illuminate\Support\Facades\Log;

class CountryApiController extends Controller
{
    public function index()
    {
        try {
            return ResponseHelper::successResponse(
                data: [
                    'countries' => CountryApiResource::collection((new CountryService())->listCountries())
                ]
            );
        } catch (\Exception|\TypeError $exception) {
            Log::error($exception->getMessage());
            return ResponseHelper::errorResponse(error: trans('api.something went wrong'));
        }
    }
}
