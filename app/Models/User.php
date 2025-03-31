<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
class User extends Authenticatable
{
    use Notifiable;
    use HasRoles;

    protected $fillable = [
        'created_at',
        'email',
        'email_verified_at',
        'name',
        'password',
        'remember_token',
        'rfc',
        'ultimo_acceso',
        'updated_at',
        'verification_token',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'verification_token',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'email_verified_at' => 'datetime',
        'ultimo_acceso' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function getAuthIdentifierName()
    {
        return 'rfc';
    }
}