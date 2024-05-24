<?php

namespace App\Http\Requests\Api\Advertisement;

use App\DTOs\Advertisement\FilterAdvertisementDTO;
use Illuminate\Foundation\Http\FormRequest;

class FilterAdvertisementApiRequest extends FormRequest
{
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
            'category_id' => 'sometimes|nullable|integer|min:1|exists:categories,id',
            'is_negotiable' => 'sometimes|nullable|boolean',
            'price_from' => 'sometimes|nullable|integer|min:0',
            'price_to' => 'sometimes|nullable|integer|min:1',
            'nationality_id' => 'sometimes|nullable|exists:nationalities,id',
            'state_id' => 'sometimes|nullable|exists:states,id',
            'city_id' => 'sometimes|nullable|exists:cities,id',
//            'latitude' => 'required',
//            'longitude' => 'required',
        ];
    }

    public function getDTO(): FilterAdvertisementDTO
    {
        return FilterAdvertisementDTO::from(request()->all());
    }
}
