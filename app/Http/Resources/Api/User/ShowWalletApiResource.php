<?php

namespace App\Http\Resources\Api\User;

use App\Models\Nationality;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShowWalletApiResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $country_key = request()->header('country-key', 'SA');
        $currency = $country_key == 'SA' ? 'SAR' : ($country_key == 'EG' ? 'EGP' : 'AED');
        $user_balance = $currency == 'SAR' ? $this->balance_sar : ( $currency== 'EGP' ? $this->balance_egp : $this->balance_aed);

        return [
            'balance' => $user_balance,
            'currency' => $currency,
        ];
    }
}
