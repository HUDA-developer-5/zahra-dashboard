<?php

namespace App\Http\Resources\Api\Advertisement;

use App\Http\Resources\Api\CategoryApiResource;
use App\Http\Resources\Api\CityApiResource;
use App\Http\Resources\Api\NationalityApiResource;
use App\Http\Resources\Api\StateApiResource;
use App\Http\Resources\Api\User\SimpleUserApiResource;
use App\Services\Advertisement\AdvertisementService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ChatAdvertisementApiResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'message' => $this->message,
            'created_at' => $this->created_at->toDateTimeString(),
            'owner' => ($this->admin) ? SimpleAdminApiResource::make($this->admin) : SimpleUserApiResource::make($this->user),
        ];
    }
}
