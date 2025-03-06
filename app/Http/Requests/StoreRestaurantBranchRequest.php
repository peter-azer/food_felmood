<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRestaurantBranchRequest extends FormRequest
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
            'restaurant_id' => ['required', 'integer', 'exists:restaurants,id'],
            'area_id' => ['required', 'integer', 'exists:areas,id'],
            'branch_code' => ['required', 'string', 'max:255'],
            'phone_number' => ['required', 'string', 'max:255'],
            'optional_phone_number' => ['nullable', 'string', 'max:255'],
            'location' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'menu' => ['required', 'string', 'max:255'],
        ];
    }
}
