<?php

/**
 * @license Apache 2.0
 */

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class StoreProductRequest.
 *
 * @author <admin@admin.com>
 *
 * @OA\Schema(
 *     description="Crud product",
 *     title="Product"
 * )
 */

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
            'price' => 'numeric|required',
            'description' => 'string|nullable|max:200',
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
            'name.string' => 'Nome deve ser texto',
            'name.max' => 'Nome: Máximo 50 caracteres',
            'price.numeric' => 'Preço deve do tipo número',
            'price.required' => 'Preço é obrigatório',
            'description.string' => 'Descrição deve ser do tipo texto',
            'description.max' => 'Descrição: máximo 200 caracteres',
        ];
    }

    /**
     * @OA\Property(
     *     description="Product name",
     * )
     *
     * @var string
     */
    private $name;

    /**
     * @OA\Property(
     *     description="Product price",
     *     default=487.65
     * )
     *
     * @var float
     */
    private $price;

    /**
     * @OA\Property(
     *     description="Product description",
     * )
     *
     * @var string
     */
    private $description;
}
