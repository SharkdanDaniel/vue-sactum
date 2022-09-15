<?php

/**
 * @license Apache 2.0
 */

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;

/**
 * Class User.
 *
 * @OA\Schema(
 *     title="User model",
 *     description="User model",
 * )
 */

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'email_verified_at'
        
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected static function booted() // exclui o admin das consultas
    {
        // static::addGlobalScope('exclude', function (Builder $builder) {
        //     Auth::check() ? $builder->where('email', '<>', 'admin@admin.com') : null;
        // });
    }

    /**
     * @OA\Property(
     *     description="User ID",
     *     default=48
     * )
     *
     * @var string
     */
    private $id;

    /**
     * @OA\Property(
     *     description="user name",
     * )
     *
     * @var string
     */
    private $name;

    /**
     * @OA\Property(
     *     format="email",
     *     description="User email",
     * )
     *
     * @var string
     */
    private $email;
}
