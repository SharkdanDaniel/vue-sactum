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
     *     default=200
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
     *     default="API message response"
     * )
     *
     * @var string
     */
    private $message;
}