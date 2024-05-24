<?php

namespace App\Http\Requests\Api\User\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class ResetPasswordApiRequest extends FormRequest
{
    protected $errorBag = 'resetPassword';

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
            'token' => 'required',
            'password' => ['required', Password::min(8)
//                ->letters()
//                ->mixedCase()
//                ->numbers()
//                ->symbols()
//                ->uncompromised()
                , 'confirmed'],
        ];
    }
}
