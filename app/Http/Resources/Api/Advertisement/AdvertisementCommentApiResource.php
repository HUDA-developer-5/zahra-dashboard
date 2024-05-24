<?php

namespace App\Http\Resources\Api\Advertisement;

use App\Http\Resources\Api\User\SimpleUserApiResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdvertisementCommentApiResource extends JsonResource
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
            'comment' => $this->comment,
            'created_at' => $this->created_at->diffForHumans(),
            'parent' => $this->parent,
            'user' => SimpleUserApiResource::make($this->user),
            'relatedComments' => AdvertisementCommentApiResource::collection($this->relatedComments)
        ];
    }
}
