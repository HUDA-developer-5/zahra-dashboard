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

class AdvertisementApiResource extends JsonResource
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
            'name' => $this->name,
            'status' => $this->status,
            'is_sold' => (bool)$this->is_sold,
            'is_favourite' => (auth('api')->check()) ? (new AdvertisementService())->isFavouriteAds(auth('api')->id(), $this->id) : false,
            'is_negotiable' => (bool)$this->is_negotiable,
            'price_type' => $this->price_type,
            'price' => (string)$this->price,
            'min_price' => (string)$this->min_price,
            'max_price' => (string)$this->max_price,
            'currency' => $this->currency,
            'created_at' => $this->created_at->format('Y-m-d'),
            'phone_number' => $this->phone_number,
            'whatsapp_number' => $this->whatsapp_number,
            'type' => $this->type,
            'image' => $this->image_path,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'description' => $this->description,
            'images' => AdvertisementMediaApiResource::collection($this->images),
            'videos' => AdvertisementMediaApiResource::collection($this->videos),
            'user' => SimpleUserApiResource::make($this->user),
            'nationality' => NationalityApiResource::make($this->nationality),
            'state' => StateApiResource::make($this->state),
            'city' => CityApiResource::make($this->city),
            'category' => CategoryApiResource::make($this->category),
            'sub_category_1' => $this->sub_category_id_1 ? CategoryApiResource::make($this->subCategory1) : null,
            'sub_category_2' => $this->sub_category_id_2 ? CategoryApiResource::make($this->subCategory2) : null,
            'sub_category_3' => $this->sub_category_id_3 ? CategoryApiResource::make($this->subCategory3) : null
        ];
    }
}
