<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'string|max:50|required',
            'price' => 'number|max:50|required',
            'description' => 'string|max:200',
        ];
    }

    /**
     * Return validation messages.
     *
     * @return array<string, string>
     */
    public function messages()
    {
        return [
            'name.required' => 'Obrigatório',
            'name.string' => 'Deve ser texto',
            'name.max' => 'Máximo 50 caracteres',
            'price.number' => 'Deve ser número',
            'price.required' => 'Obrigatório',
            'price.max' => 'Máximo 50 caracteres',
            'description.string' => 'Deve ser texto',
            'description.max' => 'Máximo 200 caracteres',
        ];
    }
}
