<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    const TABLE_NAME = 'users';

    /** @var string */
    protected $table = self::TABLE_NAME;

    /** @var array */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /** @var array */
    protected $hidden = [
        'password', 'remember_token',
    ];
}
