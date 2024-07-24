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
}
