<?php

/**
 * @license Apache 2.0
 */

namespace App\Models;

/**
 * Class ApiResponse.
 *
 * @author <admin@admin.com>
 *
 * @OA\Schema(
 *     description="Api response",
 *     title="Api response"
 * )
 */
class ApiResponse
{
    /**
     * @OA\Property(
     *     description="Status code",
     * )
     *
     * @var int
     */
    private $code;

    /**
     * @OA\Property(
     *    description="Response type",
     * ).
     *
     * @var string
     */
    private $type;

    /**
     * @OA\Property(
     *     description="Reponse message",
     * )
     *
     * @var string
     */
    private $message;
}