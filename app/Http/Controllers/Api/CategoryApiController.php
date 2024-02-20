<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\CategoryApiResource;
use App\Services\CategoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CategoryApiController extends Controller
{
    public function index()
    {
        try {
//            return CategoryApiResource::collection((new CategoryService())->list());
            return ResponseHelper::successResponse(
                data: [
                    'categories' => CategoryApiResource::collection((new CategoryService())->listParent())
                ]
            );
        } catch (\Exception|\TypeError $exception) {
            Log::error($exception->getMessage());
            return ResponseHelper::errorResponse(error: trans('api.something went wrong'));
        }
    }

    public function listChild(int $id)
    {
        try {
            return ResponseHelper::successResponse(
                data: [
                    'categories' => CategoryApiResource::collection((new CategoryService())->listChild($id))
                ]
            );
        } catch (\Exception|\TypeError $exception) {
            dd($exception->getMessage());
            Log::error($exception->getMessage());
            return ResponseHelper::errorResponse(error: trans('api.something went wrong'));
        }
    }
}
