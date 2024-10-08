<?php

namespace App\Http\Resources\Api\User;

use App\Http\Resources\Api\NationalityApiResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserApiResource extends JsonResource
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
            'phone_number' => $this->phone_number,
            'email' => $this->email,
            'nationality' => NationalityApiResource::make($this->nationality)
        ];
    }
}
