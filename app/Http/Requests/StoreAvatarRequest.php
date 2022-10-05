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
            'image' => 'image|mimes:jpg,png,jpeg,gif,svg|max:5000|required',
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
            'image.required' => 'Imagem é obrigatória',
            'image.image' => 'Imagem deve ser do tipo image',
            'image.mimes' => 'Extensões suportadas: jpg, png, jpeg, gif, svg',
            'image.max' => 'Tamanho máximo suportado de 5 MB',
            'image.uploaded' => 'Tamanho da image é muito grande!',
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
