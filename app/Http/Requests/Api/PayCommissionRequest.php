<?php

namespace App\Http\Requests\Api;

use App\DTOs\User\PayCommissionDTO;
use App\Enums\CommissionPayWithTypesEnums;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PayCommissionRequest extends FormRequest
{
    protected $errorBag = "commission";

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
            'commission_id' => 'required',
            'payment_type' => ['required', Rule::enum(CommissionPayWithTypesEnums::class)],
        ];
    }

    public function getDTO(): PayCommissionDTO
    {
        return PayCommissionDTO::from(request()->all());
    }
}
