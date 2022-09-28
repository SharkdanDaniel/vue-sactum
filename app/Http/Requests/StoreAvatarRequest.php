<?php

/**
 * @license Apache 2.0
 */

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class StoreAvatarRequest.
 *
 * @author <admin@admin.com>
 *
 * @OA\Schema(
 *     description="Crud avatar",
 *     title="Avatar"
 * )
 */

class StoreAvatarRequest extends FormRequest
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
            'image' => 'image|mimes:jpg,png,jpeg,gif,svg|required',
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
            'image.required' => 'Obrigatório',
            'image' => 'Deve ser do tipo imagem',
            'mimes' => 'Extensões suportadas: jpg, png, jpeg, gif, svg'
        ];
    }

    /**
     * @OA\Property(
     *     description="Image",
     * )
     *
     * @var image
     */
    private $image;
}
