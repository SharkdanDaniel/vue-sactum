<?php

/**
 * @license Apache 2.0
 */

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class LoginRequest.
 *
 * @author <admin@admin.com>
 *
 * @OA\Schema(
 *     description="Login request",
 *     title="Login"
 * )
 */

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

    /**
     * @OA\Property(
     *     format="email",
     *     description="Autentication email",
     * )
     *
     * @var string
     */
    private $email;

    /**
     * @OA\Property(
     *     format="password",
     *     description="Autentication password",
     * )
     *
     * @var string
     */
    private $password;
}
