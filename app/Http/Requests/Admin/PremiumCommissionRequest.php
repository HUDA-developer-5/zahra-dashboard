<?php

namespace App\Http\Requests\Admin;

use App\Enums\Advertisement\PremiumCommissionTypeEnums;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PremiumCommissionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // only allow updates if the user is logged in
        return backpack_auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
//            'type' => ['required', Rule::enum(PremiumCommissionTypeEnums::class)],
            'commission' => ['required', 'integer'],
//            'days' => ['required', 'integer', Rule::unique('premium_commissions')->ignore($this->id)]
        ];
    }

    /**
     * Get the validation attributes that apply to the request.
     *
     * @return array
     */
    public function attributes()
    {
        return [
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            //
        ];
    }
}
