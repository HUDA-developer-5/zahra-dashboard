<?php

namespace App\Http\Resources\Api\Advertisement;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SimpleAdvertisementApiResource extends JsonResource
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
            'image' => $this->image_path,
            'price' => (string)$this->default_price,
            'currency' => $this->currency,
            'category' => $this->category?->name,
            'created_at' => $this->created_at->toDateTimeString(),
            'country' => $this->nationality?->name,
            'state' => $this->state?->name,
        ];
    }
}
