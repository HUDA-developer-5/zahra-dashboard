<?php

namespace App\Http\Requests\Api\Advertisement;

use App\DTOs\Advertisement\UpdateAdvertisementDTO;
use App\Enums\Advertisement\AdvertisementPriceTypeEnums;
use App\Enums\Advertisement\AdvertisementStatusEnums;
use App\Enums\Advertisement\AdvertisementTypeEnums;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;

class UpdateAdvertisementApiRequest extends FormRequest
{
    protected $errorBag = 'update_product';
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
            'name' => 'sometimes|nullable|max:255',
            'category_id' => 'sometimes|nullable|integer|min:1|exists:categories,id',
            'is_sold' => 'sometimes|nullable|boolean',
            'is_negotiable' => 'sometimes|nullable|boolean',
            'status' => ['sometimes','nullable', Rule::enum(AdvertisementStatusEnums::class)],
            'price_type' => ['sometimes','nullable', Rule::enum(AdvertisementPriceTypeEnums::class)],
            'price' => 'required_if:price_type,' . AdvertisementPriceTypeEnums::Fixed->value,
            'min_price' => 'required_if:price_type,' . AdvertisementPriceTypeEnums::OpenOffer->value,
            'max_price' => 'required_if:price_type,' . AdvertisementPriceTypeEnums::OpenOffer->value,
            'phone_number' => 'sometimes|nullable',
            'whatsapp_number' => 'sometimes|nullable',
            'type' => ['sometimes','nullable', Rule::enum(AdvertisementTypeEnums::class)],
            'currency' => 'sometimes|nullable|exists:nationalities,currency',
            'nationality_id' => 'sometimes|nullable|exists:nationalities,id',
            'state_id' => 'sometimes|nullable|exists:states,id',
            'city_id' => 'sometimes|nullable|exists:cities,id',
//            'latitude' => 'required',
//            'longitude' => 'required',
//            'description' => 'required',
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
        ];
    }

    public function getDTO(): UpdateAdvertisementDTO
    {
        return UpdateAdvertisementDTO::from(request()->all());
    }
}
