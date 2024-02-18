<?php

namespace App\Http\Requests\Api\User\Auth;

use App\DTOs\User\UpdateUserProfileDTO;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;
use Illuminate\Validation\Rules\Password;

class UpdateUserProfileApiRequest extends FormRequest
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
        $id = auth('api')->id();
        return [
            'name' => 'nullable|max:200|required_without_all:phone_number,email,country_id,image',
            'phone_number' => ['sometimes', 'nullable', 'phone:mobile', Rule::unique('users', 'phone_number')->ignore($id, 'id')],
            'email' => ['sometimes', 'nullable', 'email::rfc,dns', Rule::unique('users', 'email')->ignore($id, 'id')],
            'country_id' => ['sometimes', 'nullable', 'exists:countries,id'],
            'image' => ['sometimes', 'nullable', File::image()
                ->min(1)
                ->max(2 * 1024)
//                ->dimensions(Rule::dimensions()->maxWidth(1000)->maxHeight(500))
            ],
        ];
    }

    public function getDTO()
    {
        return UpdateUserProfileDTO::from(request()->only(['name', 'phone_number', 'email', 'country_id', 'image']));
    }
}
