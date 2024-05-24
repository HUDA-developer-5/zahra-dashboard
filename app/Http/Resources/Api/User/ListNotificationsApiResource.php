<?php

namespace App\Http\Resources\Api\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ListNotificationsApiResource extends JsonResource
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
            'title' => $this->{"title_" . app()->getLocale()},
            'content' => $this->{"content_" . app()->getLocale()},
            'image' => $this->targetUser?->image_path,
            'created_at' => $this->created_at->format('d/m/Y'),
            'action' => $this->action,
            'is_read' => (bool)$this->is_read,
            'payload' => $this->payload,
        ];
    }
}
