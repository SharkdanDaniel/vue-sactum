<?php

/**
 * @license Apache 2.0
 */

namespace App\Models;

/**
 * Class ProductList.
 *
 * @author <admin@admin.com>
 *
 * @OA\Schema(
 *     description="ProductList",
 *     title="ProductList"
 * )
 */
class ProductList extends ApiPaginatorResponse
{
    /**
     * @OA\Property(
     *     description="Product list",
     *     @OA\Items(ref="#/components/schemas/Product")
     * )
     *
     * @var array
     */
    private $data;
}