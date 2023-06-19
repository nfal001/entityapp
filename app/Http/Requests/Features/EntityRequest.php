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
            'name'=>'required|min:3|max:32',
            'price'=>'required|numeric|min:1|max:4000000',
            'city'=>'required|integer',
            'district'=>'required|integer',
            'status'=>'required|string'
        ];
    }
}
