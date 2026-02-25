<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRestaurantRequest extends FormRequest
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
            'name' => 'required|string|min:3',
            'slug' => 'required|string|min:3',
            'description' => 'nullable|string',
            'phone' => 'nullable|regex:/^\+?[0-9]{10,15}$/',
            'email' => 'required|email',
            'address' => 'required|string|min:10',
            'city' => 'required|string|min:3',
            'state' => 'required|string|min:2|max:3',
            'zip_code' => 'required|string|regex:/^\d{5}-\d{3}$/'
        ];
    }
}
