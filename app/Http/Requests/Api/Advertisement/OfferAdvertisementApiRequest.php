<?php

namespace App\Http\Requests\Api\Advertisement;

use Illuminate\Foundation\Http\FormRequest;

class OfferAdvertisementApiRequest extends FormRequest
{
    protected $errorBag = 'offer';

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
            'offer' => 'required|integer|min:1'
        ];
    }
}
