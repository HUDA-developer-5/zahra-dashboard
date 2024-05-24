<?php

namespace App\Http\Requests\Api\Advertisement;

use Illuminate\Foundation\Http\FormRequest;

class CommentAdvertisementApiRequest extends FormRequest
{
    protected $errorBag = 'product_comment';

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
            'comment' => 'required',
            'parent' => 'sometimes|nullable|integer|exists:user_ads_comments,id',
        ];
    }
}
