<?php

namespace App\Http\Resources\Api\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ListCardsApiResource extends JsonResource
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
            'expire_month' => $this->expire_month,
            'expire_year' => $this->expire_year,
            'last_four_numbers' => $this->last_four_numbers,
            'brand' => $this->brand,
            'is_default' => $this->is_default,
        ];
    }
}
