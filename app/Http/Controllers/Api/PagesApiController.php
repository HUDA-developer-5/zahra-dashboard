<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\BannerApiResource;
use App\Http\Resources\Api\StaticPageApiResource;
use App\Services\Advertisement\AdvertisementService;
use App\Services\DynamicPageService;
use Illuminate\Support\Facades\Log;

class PagesApiController extends Controller
{
    public function getPage(string $page)
    {
        try {
            $page = (new DynamicPageService())->getPage($page);
            if (!$page) {
                return ResponseHelper::errorResponse(error: trans('api.not found'));
            }
            return ResponseHelper::successResponse(
                data: [
                    'page' => StaticPageApiResource::make($page)
                ]
            );
        } catch (\Exception|\TypeError $exception) {
            Log::error($exception->getMessage());
            return ResponseHelper::errorResponse(error: trans('api.something went wrong'));
        }
    }

    public function getBanner()
    {
        try {
            $banner = (new AdvertisementService())->getActiveBanner();
            if (!$banner) {
                return ResponseHelper::errorResponse(error: trans('api.not found'));
            }
            return ResponseHelper::successResponse(
                data: [
                    'banner' => BannerApiResource::make($banner)
                ]
            );
        } catch (\Exception|\TypeError $exception) {
            Log::error($exception->getMessage());
            return ResponseHelper::errorResponse(error: trans('api.something went wrong'));
        }
    }
}
