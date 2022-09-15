<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Product.
 *
 * @OA\Schema(
 *     title="Product model",
 *     description="Product model",
 * )
 */

class Product extends Model
{
    use HasFactory, UUID;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'price',
        'description',
    ];

    /**
     * @OA\Property(
     *     format="uuid",
     *     description="Product ID",
     * )
     *
     * @var string
     */
    private $id;

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
     *     default=451.45
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
