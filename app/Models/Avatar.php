<?php

/**
 * @license Apache 2.0
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UUID;

/**
 * Class Avatar.
 *
 * @OA\Schema(
 *     title="Avatar model",
 *     description="Avatar model",
 * )
 */

class Avatar extends Model
{
    use HasFactory, UUID;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'file_name',
        'media_type',
        'path',
        'data',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @OA\Property(
     *     format="uuid",
     *     description="Avatar ID",
     * )
     *
     * @var string
     */
    private $id;

    /**
     * @OA\Property(
     *     description="User ID",
     *     default=4
     * )
     *
     * @var string
     */
    private $user_id;

    /**
     * @OA\Property(
     *     description="File name",
     * )
     *
     * @var string
     */
    private $file_name;

    /**
     * @OA\Property(
     *     description="Media type",
     * )
     *
     * @var string
     */
    private $media_type;

    /**
     * @OA\Property(
     *     description="Data base64",
     * )
     *
     * @var string
     */
    private $data;
}
