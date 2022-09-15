<?php

/**
 * @license Apache 2.0
 */

namespace App\Models;

/**
 * Class LoginResponse.
 *
 * @author <admin@admin.com>
 *
 * @OA\Schema(
 *     description="Login response",
 *     title="Login response"
 * )
 */
class LoginResponse
{
    /**
     * @OA\Property(
     *     description="Token",
     *     default="1|tYfXgGERi0gcGH7Vdu6TYdWdijCCdrdPjY6jGBphAnwx"
     * )
     *
     * @var string
     */
    private $access_token;

    /**
     * @OA\Property(
     *    description="Token type",
     *    default="bearer"
     * ).
     *
     * @var string
     */
    private $token_type;

    /**
     * @OA\Property(
     *     description="User data",
     * )
     *
     * @var User
     */
    private $user;
}