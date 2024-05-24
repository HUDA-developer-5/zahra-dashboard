<?php

namespace App\Http\Requests\Api;

use App\DTOs\User\PayCommissionDTO;
use App\Enums\CommissionPayWithTypesEnums;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PayPremiumSubscriptionRequest extends FormRequest
{
    protected $errorBag = "premium_subscription";

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'payment_type' => ['required', Rule::enum(CommissionPayWithTypesEnums::class)],
        ];
    }

    public function getDTO(): PayCommissionDTO
    {
        return PayCommissionDTO::from(request()->all());
    }
}
