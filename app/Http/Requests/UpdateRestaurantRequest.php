<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRestaurantRequest extends FormRequest
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
            'name' => 'nullable|string|min:3',
            'slug' => 'nullable|string|min:3',
            'description' => 'nullable|string',
            'phone' => 'nullable|regex:/^\+?[0-9]{10,15}$/',
            'email' => 'nullable|email',
            'address' => 'nullable|string|min:10',
            'city' => 'nullable|string|min:3',
            'state' => 'nullable|string|min:2|max:3',
            'zip_code' => 'nullable|string|regex:/^\d{5}-\d{3}$/'
        ];
    }
}
