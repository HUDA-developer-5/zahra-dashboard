<?php

namespace App\Http\Resources\Api\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ListCommissionsApiResource extends JsonResource
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
            'advertisement' => ['id' => $this->advertisement_id, 'name' => $this->advertisement?->name],
            'amount' => $this->amount,
            'commission' => $this->commission,
            'amount_after_commission' => $this->amount_after_commission,
            'currency' => $this->currency,
            'is_paid' => $this->is_paid,
        ];
    }
}
