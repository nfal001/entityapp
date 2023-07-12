<?php

namespace App\Http\Requests\Features;

use Illuminate\Foundation\Http\FormRequest;

class EntityRequest extends FormRequest
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
            'name' => 'required|min:3|max:32',
            'price' => 'required|numeric|min:1|max:4000000',
            'image_url' => 'required|url',
            'city_id' => 'required|integer',
            'district_id' => 'required|integer',
            'entity_status' => 'required|string',
            "entity_detail.description" => "nullable",
            "entity_detail.hd_image_url" => "required",
        ];
    }
}
