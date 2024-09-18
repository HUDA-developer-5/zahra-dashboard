<?php

namespace App\Http\Requests\Api\Advertisement;

use App\DTOs\Advertisement\CreateAdvertisementDTO;
use App\Enums\Advertisement\AdvertisementPriceTypeEnums;
use App\Enums\Advertisement\AdvertisementTypeEnums;
use App\Enums\CommissionPayWithTypesEnums;
use App\Models\Category;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;

class AdvertisementApiRequest extends FormRequest
{
    protected $errorBag = 'add_product';

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|max:255',
            'category_id' => 'required|integer|min:1|exists:categories,id',
            'sub_category_id_1' => ['nullable', 'integer', 'min:1', 'exists:categories,id',],
            'sub_category_id_2' => ['nullable', 'integer', 'min:1', 'exists:categories,id',],
            'sub_category_id_3' => ['nullable', 'integer', 'min:1', 'exists:categories,id',],
            'is_negotiable' => 'required|boolean',
            'price_type' => ['required', Rule::enum(AdvertisementPriceTypeEnums::class)],
            'price' => ['nullable', 'required_if:price_type,' . AdvertisementPriceTypeEnums::Fixed->value, 'integer', 'min:1'],
            'min_price' => ['nullable', 'required_if:price_type,' . AdvertisementPriceTypeEnums::OpenOffer->value, 'integer', 'min:1', 'lt:max_price'],
            'max_price' => ['nullable', 'required_if:price_type,' . AdvertisementPriceTypeEnums::OpenOffer->value, 'integer', 'min:1', 'gt:min_price'],
            'phone_number' => [
                'required',
                'string',
                'min:11', // Ensures at least 11 digits
                'regex:/^[0-9]+$/', // Ensures only digits
            ],
            'whatsapp_number' => [
                'required',
                'string',
                'min:11', // Ensures at least 11 digits
                'regex:/^[0-9]+$/', // Ensures only digits
            ],
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

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $this->validateCategoryHierarchy($validator);
        });
    }

    protected function validateCategoryHierarchy($validator)
    {
        $categoryId = $this->input('category_id');
        $subCategoryId1 = $this->input('sub_category_id_1');
        $subCategoryId2 = $this->input('sub_category_id_2');
        $subCategoryId3 = $this->input('sub_category_id_3');

        $this->validateSubCategory($validator, $categoryId, $subCategoryId1, 'sub_category_id_1');
        $this->validateSubCategory($validator, $subCategoryId1, $subCategoryId2, 'sub_category_id_2');
        $this->validateSubCategory($validator, $subCategoryId2, $subCategoryId3, 'sub_category_id_3');
    }

    protected function validateSubCategory($validator, $parentCategoryId, $subCategoryId, $subCategoryField)
    {
        if (is_null($parentCategoryId)) {
            return;
        }

        $parentCategory = Category::find($parentCategoryId);

        if ($parentCategory && $parentCategory->child()->count() > 0 && is_null($subCategoryId)) {
            $validator->errors()->add($subCategoryField, "The {$subCategoryField} field is required because the parent category has subcategories.");
        }
    }

    public function messages()
    {
        return [
            'name.required' => __('validation.required', ['attribute' => __('validation.attributes.name')]),
            'name.max' => __('validation.max.string', ['attribute' => __('validation.attributes.name'), 'max' => 255]),
            'category_id.required' => __('validation.required', ['attribute' => __('validation.attributes.category_id')]),
            'category_id.integer' => __('validation.integer', ['attribute' => __('validation.attributes.category_id')]),
            'category_id.min' => __('validation.min.numeric', ['attribute' => __('validation.attributes.category_id'), 'min' => 1]),
            'category_id.exists' => __('validation.exists', ['attribute' => __('validation.attributes.category_id')]),
            'sub_category_id_1.integer' => __('validation.integer', ['attribute' => __('validation.attributes.sub_category_id_1')]),
            'sub_category_id_1.min' => __('validation.min.numeric', ['attribute' => __('validation.attributes.sub_category_id_1'), 'min' => 1]),
            'sub_category_id_1.exists' => __('validation.exists', ['attribute' => __('validation.attributes.sub_category_id_1')]),
            'sub_category_id_2.integer' => __('validation.integer', ['attribute' => __('validation.attributes.sub_category_id_2')]),
            'sub_category_id_2.min' => __('validation.min.numeric', ['attribute' => __('validation.attributes.sub_category_id_2'), 'min' => 1]),
            'sub_category_id_2.exists' => __('validation.exists', ['attribute' => __('validation.attributes.sub_category_id_2')]),
            'sub_category_id_3.integer' => __('validation.integer', ['attribute' => __('validation.attributes.sub_category_id_3')]),
            'sub_category_id_3.min' => __('validation.min.numeric', ['attribute' => __('validation.attributes.sub_category_id_3'), 'min' => 1]),
            'sub_category_id_3.exists' => __('validation.exists', ['attribute' => __('validation.attributes.sub_category_id_3')]),
            'is_negotiable.required' => __('validation.required', ['attribute' => __('validation.attributes.is_negotiable')]),
            'is_negotiable.boolean' => __('validation.boolean', ['attribute' => __('validation.attributes.is_negotiable')]),
            'price_type.required' => __('validation.required', ['attribute' => __('validation.attributes.price_type')]),
            'price.required_if' => __('validation.required_if', ['attribute' => __('validation.attributes.price'), 'other' => __('validation.attributes.price_type'), 'value' => 'fixed']),
            'price.integer' => __('validation.integer', ['attribute' => __('validation.attributes.price')]),
            'price.min' => __('validation.min.numeric', ['attribute' => __('validation.attributes.price'), 'min' => 1]),
            'min_price.required_if' => __('validation.required_if', ['attribute' => __('validation.attributes.min_price'), 'other' => __('validation.attributes.price_type'), 'value' => 'open_offer']),
            'min_price.integer' => __('validation.integer', ['attribute' => __('validation.attributes.min_price')]),
            'min_price.min' => __('validation.min.numeric', ['attribute' => __('validation.attributes.min_price'), 'min' => 1]),
            'min_price.lt' => __('validation.lt.numeric', ['attribute' => __('validation.attributes.min_price'), 'value' => __('validation.attributes.max_price')]),
            'max_price.required_if' => __('validation.required_if', ['attribute' => __('validation.attributes.max_price'), 'other' => __('validation.attributes.price_type'), 'value' => 'open_offer']),
            'max_price.integer' => __('validation.integer', ['attribute' => __('validation.attributes.max_price')]),
            'max_price.min' => __('validation.min.numeric', ['attribute' => __('validation.attributes.max_price'), 'min' => 1]),
            'max_price.gt' => __('validation.gt.numeric', ['attribute' => __('validation.attributes.max_price'), 'value' => __('validation.attributes.min_price')]),
            'phone_number.required' => __('validation.required', ['attribute' => __('validation.attributes.phone_number')]),
            'whatsapp_number.required' => __('validation.required', ['attribute' => __('validation.attributes.whatsapp_number')]),
            'type.required' => __('validation.required', ['attribute' => __('validation.attributes.type')]),
            'currency.required' => __('validation.required', ['attribute' => __('validation.attributes.currency')]),
            'currency.exists' => __('validation.exists', ['attribute' => __('validation.attributes.currency')]),
            'nationality_id.required' => __('validation.required', ['attribute' => __('validation.attributes.nationality_id')]),
            'nationality_id.exists' => __('validation.exists', ['attribute' => __('validation.attributes.nationality_id')]),
            'state_id.required' => __('validation.required', ['attribute' => __('validation.attributes.state_id')]),
            'state_id.exists' => __('validation.exists', ['attribute' => __('validation.attributes.state_id')]),
            'city_id.required' => __('validation.required', ['attribute' => __('validation.attributes.city_id')]),
            'city_id.exists' => __('validation.exists', ['attribute' => __('validation.attributes.city_id')]),
            'latitude.required' => __('validation.required', ['attribute' => __('validation.attributes.latitude')]),
            'longitude.required' => __('validation.required', ['attribute' => __('validation.attributes.longitude')]),
            'description.required' => __('validation.required', ['attribute' => __('validation.attributes.description')]),
            'image.image' => __('validation.image', ['attribute' => __('validation.attributes.image')]),
            'images.array' => __('validation.array', ['attribute' => __('validation.attributes.images')]),
            'images.max' => __('validation.max.array', ['attribute' => __('validation.attributes.images'), 'max' => 20]),
            'images.*.image' => __('validation.image', ['attribute' => __('validation.attributes.image')]),
            'videos.array' => __('validation.array', ['attribute' => __('validation.attributes.videos')]),
            'videos.max' => __('validation.max.array', ['attribute' => __('validation.attributes.videos'), 'max' => 5]),
            'videos.*.file' => __('validation.file', ['attribute' => __('validation.attributes.video')]),
            'premium_amount.required_if' => __('validation.required_if', ['attribute' => __('validation.attributes.premium_amount'), 'other' => __('validation.attributes.type'), 'value' => 'premium']),
            'premium_amount.integer' => __('validation.integer', ['attribute' => __('validation.attributes.premium_amount')]),
            'premium_amount.min' => __('validation.min.numeric', ['attribute' => __('validation.attributes.premium_amount'), 'min' => 1]),
            'payment_type.required_if' => __('validation.required_if', ['attribute' => __('validation.attributes.payment_type'), 'other' => __('validation.attributes.type'), 'value' => 'premium']),
            'payment_method.required_if' => __('validation.required_if', ['attribute' => __('validation.attributes.payment_method'), 'other' => __('validation.attributes.payment_type'), 'value' => 'card']),
        ];
    }


}
