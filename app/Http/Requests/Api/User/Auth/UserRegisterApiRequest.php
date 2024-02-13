<?php

namespace App\Http\Requests\Api\User\Auth;

use App\DTOs\User\UserRegisterDTO;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UserRegisterApiRequest extends FormRequest
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
            'name' => 'required|max:200',
            'phone_number' => 'required|unique:users,phone_number|phone:mobile',
            'email' => 'required|email::rfc,dns|unique:users,email',
            'password' => ['required', Password::min(8)
//                ->letters()
//                ->mixedCase()
//                ->numbers()
//                ->symbols()
//                ->uncompromised()
                , 'confirmed'],
        ];
    }

    public function getDTO(): UserRegisterDTO
    {
        return UserRegisterDTO::from([
            'name' => $this->name,
            'phone_number' => $this->phone_number,
            'email' => $this->email,
            'password' => $this->password,
        ]);
    }
}
