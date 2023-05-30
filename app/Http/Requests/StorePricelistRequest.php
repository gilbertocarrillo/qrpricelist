<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePricelistRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'currency' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'phone:INTERNATIONAL'],
            'whatsapp' => ['nullable', 'phone:INTERNATIONAL'],
            'logo' => ['nullable', 'image', 'mimes:jpeg,png,jpg'],
            'cover' => ['nullable', 'image', 'mimes:jpeg,png,jpg'],
            'facebook' => ['nullable',  'url'],
            'instagram' => ['nullable',  'url'],
            'twitter' => ['nullable',  'url'],
        ];
    }
}
