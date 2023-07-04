<?php

namespace App\Http\Requests\Features;

use Illuminate\Foundation\Http\FormRequest;

class AddressRequest extends FormRequest
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
            "receiver_name" => "required",
            "addr_name" => "required|min:4",
            "postal_code" => "required|integer",
            "address_full" => "required|max:300",
            "district_id" => "required|integer",
            "phone" => 'required|min:4',
            "city_id" => "required|integer",
            "province_id" => "required|integer",
        ];
    }
}
