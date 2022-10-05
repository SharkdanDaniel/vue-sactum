<?php

/**
 * @license Apache 2.0
 */

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'src',
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
     *     format="uuid"
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
     *     description="src in base64 format",
     * )
     *
     * @var string
     */
    private $src;
}
