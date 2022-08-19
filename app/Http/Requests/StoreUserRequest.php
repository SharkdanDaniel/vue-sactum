<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'email' => 'email|max:20|required|unique:users',
            'password' => 'string|min:8|max:20|required',
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
            'email.email' => 'Email inválido',
            'email.string' => 'Deve ser texto',
            'email.required' => 'Obrigatório',
            'email.unique' => 'Este email já existe',
            'name.max' => 'Máximo 20 caracteres',
            'password.required' => 'Obrigatório',
            'password.string' => 'Deve ser texto',
            'password.max' => 'Máximo 20 caracteres',
            'password.min' => 'Mínimo 8 caracteres',
        ];
    }
}
