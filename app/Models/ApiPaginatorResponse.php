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
     * )
     *
     * @var int
     */
    private $total;

    /**
     * @OA\Property(
     *     description="Total of data per page",
     * )
     *
     * @var int
     */
    private $per_page;

    /**
     * @OA\Property(
     *     description="Current page number",
     * )
     *
     * @var int
     */
    private $current_page;

    /**
     * @OA\Property(
     *     description="Last page number number",
     * )
     *
     * @var int
     */
    private $last_page;
    
    /**
     * @OA\Property(
     *     description="Url of the first page",
     * )
     *
     * @var string
     */
    private $first_page_url;

    /**
     * @OA\Property(
     *     description="Url of the last page",
     * )
     *
     * @var string
     */
    private $last_page_url;

    /**
     * @OA\Property(
     *     description="Url of the next page",
     * )
     *
     * @var string
     */
    private $next_page_url;

    /**
     * @OA\Property(
     *     description="Url of the previous page",
     * )
     *
     * @var string
     */
    private $prev_page_url;

    /**
     * @OA\Property(
     *    description="App path",
     * ).
     *
     * @var string
     */
    private $path;

    /**
     * @OA\Property(
     *     description="From number",
     * )
     *
     * @var int
     */
    private $from;

    /**
     * @OA\Property(
     *     description="To number",
     * )
     *
     * @var int
     */
    private $to;
}