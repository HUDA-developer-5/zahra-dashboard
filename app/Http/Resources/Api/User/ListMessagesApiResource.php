<?php

namespace App\Http\Resources\Api\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ListMessagesApiResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if ($this->offer) {
            $offer = [
                'id' => $this->offer->id,
                'price' => $this->offer->offer,
                'status' => $this->offer->status,
                'advertisement' => [
                    'id' => $this->offer->advertisement?->id,
                    'name' => $this->offer->advertisement?->name,
                    'currency' => $this->offer->advertisement?->currency,
                    'image' => $this->offer->advertisement?->image_path
                ]
            ];
        }
        return [
            'id' => $this->id,
            'sender' => [
                'id' => $this->sender?->id,
                'name' => $this->sender?->name,
                'avatar' => $this->sender?->image_path
            ],
            'receiver' => [
                'id' => $this->receiver?->id,
                'name' => $this->receiver?->name,
                'avatar' => $this->receiver?->image_path
            ],
            'created_at' => $this->created_at->format('d F Y \A\t g:i A'),
            'type' => $this->type,
            'is_read' => (bool)$this->is_read,
            'message' => $this->message,
            'offer' => $offer ?? null
        ];
    }
}
