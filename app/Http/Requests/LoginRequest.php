<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            'email' => 'email|required',
            'password' => 'string|required',
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Obrigatório',
            'email.email' => 'Email inválido',
            'password.required' => 'Obrigatório',
            'password.string' => 'Deve ser texto',
        ];
    }
}
