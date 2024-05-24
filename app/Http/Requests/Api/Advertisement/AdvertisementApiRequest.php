<?php

namespace App\Http\Requests\Api\Advertisement;

use App\DTOs\Advertisement\CreateAdvertisementDTO;
use App\Enums\Advertisement\AdvertisementPriceTypeEnums;
use App\Enums\Advertisement\AdvertisementTypeEnums;
use App\Enums\CommissionPayWithTypesEnums;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;

class AdvertisementApiRequest extends FormRequest
{
    protected $errorBag = 'add_product';
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
            'name' => 'required|max:255',
            'category_id' => 'required|integer|min:1|exists:categories,id',
            'is_negotiable' => 'required|boolean',
            'price_type' => ['required', Rule::enum(AdvertisementPriceTypeEnums::class)],
            'price' => ['nullable' ,'required_if:price_type,' . AdvertisementPriceTypeEnums::Fixed->value, 'integer', 'min:1'],
            'min_price' => ['nullable', 'required_if:price_type,' . AdvertisementPriceTypeEnums::OpenOffer->value, 'integer', 'min:1'],
            'max_price' => ['nullable', 'required_if:price_type,' . AdvertisementPriceTypeEnums::OpenOffer->value, 'integer', 'min:1'],
            'phone_number' => 'required',
            'whatsapp_number' => 'required',
            'type' => ['required', Rule::enum(AdvertisementTypeEnums::class)],
            'currency' => 'required|exists:nationalities,currency',
            'nationality_id' => 'required|exists:nationalities,id',
            'state_id' => 'required|exists:states,id',
            'city_id' => 'required|exists:cities,id',
            'latitude' => 'required',
            'longitude' => 'required',
            'description' => 'required',
            'image' => ['sometimes', 'nullable', File::image()
                ->min(1)
                ->max(2 * 1024)
//                ->dimensions(Rule::dimensions()->maxWidth(1000)->maxHeight(500))
            ],
            'images' => ['sometimes', 'nullable', 'array', 'max:20'],
            'images.*' => [File::image()
                ->min(1)
                ->max(2 * 1024)
            ],
            'videos' => ['sometimes', 'nullable', 'array', 'max:5'],
            'videos.*' => [File::types(['mp4', 'avi', 'mpeg', 'quicktime', 'webm'])
                ->min(1)
                ->max(2 * 1024)
            ],
            'premium_amount' => ['nullable', 'required_if:type,' . AdvertisementTypeEnums::Premium->value, 'integer', 'min:1'],
            'payment_type' => ['nullable', 'required_if:type,' . AdvertisementTypeEnums::Premium->value, Rule::enum(CommissionPayWithTypesEnums::class)],
            'payment_method' => ['nullable', 'required_if:payment_type,' . CommissionPayWithTypesEnums::Card->value],
        ];
    }

    public function getDTO(): CreateAdvertisementDTO
    {
        return CreateAdvertisementDTO::from(request()->all());
    }
}
