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
            'food_type_ids' => 'required|array',
            'food_type_ids.*' => 'required|integer|exists:food_types,id',
            'name' => 'required|string',
            'name_ar' => 'required|string',
            'logo' => 'required|image',
            'thumbnail' => 'required|image',
            'description' => 'required|string',
            'description_ar' => 'required|string',
            'slug' => 'required|string',
            'slug_ar' => 'required|string',
            'Rank' => 'required|unsignedBigInteger',
            'recommendation' => 'required|unsignedBigInteger',
            'cost' => 'required|string',
            'restaurant_code' => 'required|string',
            'images' => 'required|array',
            'images.*' => 'required|image',
            'hotline' => 'required|string',
        ];
    }
}
