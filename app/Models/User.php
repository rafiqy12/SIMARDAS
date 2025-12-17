<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $table = 'user';
    protected $primaryKey = 'id_user';
    public $timestamps = false;

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName(): string
    {
        return 'id_user';
    }

    protected $fillable = [
        'nama',
        'username',
        'email',
        'password',
        'role'
    ];

    protected $hidden = [
        'password'
    ];
}
