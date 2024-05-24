<?php

namespace App\Http\Resources\Api\Advertisement;

use App\Http\Resources\Api\User\SimpleUserApiResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OfferAdvertisementApiResource extends JsonResource
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
            'offer' => $this->offer,
            'status' => $this->status,
            'created_at' => $this->created_at->toDateTimeString(),
            'advertisement' => SimpleAdvertisementApiResource::make($this->advertisement),
            'user' => SimpleUserApiResource::make($this->user)
        ];
    }
}
