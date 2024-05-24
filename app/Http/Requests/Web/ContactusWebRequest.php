<?php

namespace App\Http\Requests\Web;

use App\DTOs\User\StoreContactusDTO;
use Illuminate\Foundation\Http\FormRequest;

class ContactusWebRequest extends FormRequest
{
    protected $errorBag = "contactus";

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
            'name' => 'required|max:50',
            'phone_number' => 'required|phone',
            'email' => 'sometimes|nullable|email::rfc,dns',
            'title' => 'sometimes|nullable|max:50',
            'message' => 'required|max:1000',
        ];
    }

    public function getDTO(): StoreContactusDTO
    {
        return StoreContactusDTO::from(request()->only(['name', 'phone_number', 'email', 'title', 'message']));
    }
}
