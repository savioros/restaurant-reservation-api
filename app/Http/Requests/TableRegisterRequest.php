<?php

namespace App\Http\Requests;

use App\Enums\TableLocation;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class TableRegisterRequest extends FormRequest
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
            'number' => 'required|int|min:1',
            'capacity' => 'required|int|min:1',
            'location' => ['required', new Enum(TableLocation::class)]
        ];
    }
}
