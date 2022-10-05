<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'name' => 'string|max:50|nullable',
            'email' => 'email|max:20|nullable',
            'password' => 'string|min:8|max:20|nullable',
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
            'name.required' => 'Nome é obrigatório',
            'name.string' => 'Nome deve ser do tipo texto',
            'name.max' => 'Nome: máximo 50 caracteres',
            'email.email' => 'Email inválido',
            'email.string' => 'Email deve ser do tipo texto',
            'email.required' => 'Email é obrigatório',
            'email.unique' => 'Este email já existe',
            'name.max' => 'Nome: máximo 20 caracteres',
            'password.string' => 'Senha deve ser do tipo texto',
            'password.max' => 'Senha: máximo 20 caracteres',
            'password.min' => 'Senha: mínimo 8 caracteres',
        ];
    }
}
