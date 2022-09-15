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
 *     description="Api paginator response",
 *     title="Api paginator response"
 * )
 */
class ApiPaginatorResponse
{
    /**
     * @OA\Property(
     *     description="Data total in Database",
     *     default=50
     * )
     *
     * @var int
     */
    private $total;

    /**
     * @OA\Property(
     *     description="Total of data per page",
     *     default=15
     * )
     *
     * @var int
     */
    private $per_page;

    /**
     * @OA\Property(
     *     description="Current page number",
     *     default=1
     * )
     *
     * @var int
     */
    private $current_page;

    /**
     * @OA\Property(
     *     description="Last page number number",
     *     default=4
     * )
     *
     * @var int
     */
    private $last_page;
    
    /**
     * @OA\Property(
     *     description="Url of the first page",
     *     default="http://laravel.app?page=1"
     * )
     *
     * @var string
     */
    private $first_page_url;

    /**
     * @OA\Property(
     *     description="Url of the last page",
     *     default="http://laravel.app?page=4"
     * )
     *
     * @var string
     */
    private $last_page_url;

    /**
     * @OA\Property(
     *     description="Url of the next page",
     *     default="http://laravel.app?page=2"
     * )
     *
     * @var string
     */
    private $next_page_url;

    /**
     * @OA\Property(
     *     description="Url of the previous page",
     *     default=null
     * )
     *
     * @var string
     */
    private $prev_page_url;

    /**
     * @OA\Property(
     *    description="App path",
     *    default="http://laravel.app"
     * ).
     *
     * @var string
     */
    private $path;

    /**
     * @OA\Property(
     *     description="From number",
     *     default=1
     * )
     *
     * @var int
     */
    private $from;

    /**
     * @OA\Property(
     *     description="To number",
     *     default=15
     * )
     *
     * @var int
     */
    private $to;
}