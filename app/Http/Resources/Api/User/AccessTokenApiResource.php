<?php

namespace App\Http\Resources\Api\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AccessTokenApiResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'type' => $this->tokenType ?? 'Bearer',
            'expire_at' => $this->accessTokenExpirationTime->unix(),
            'token' => $this->accessToken
        ];
    }
}
