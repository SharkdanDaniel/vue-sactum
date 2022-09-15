<?php

/**
 * @license Apache 2.0
 */

namespace App\Models;

/**
 * Class UserList.
 *
 * @author <admin@admin.com>
 *
 * @OA\Schema(
 *     description="UserList",
 *     title="UserList"
 * )
 */
class UserList extends ApiPaginatorResponse
{
    /**
     * @OA\Property(
     *     description="User list",
     *     @OA\Items(ref="#/components/schemas/User")
     * )
     *
     * @var array
     */
    private $data;
}