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
        'status',
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
        'status' => 'string',
    ];

    public function getAuthIdentifierName()
    {
        return 'rfc';
    }

    // Optional: Helper methods for status
    public function isActive()
    {
        return $this->status === 'active';
    }

    public function isInactive()
    {
        return $this->status === 'inactive';
    }

    public function isSuspended()
    {
        return $this->status === 'suspended';
    }

    // Optional: Scope for querying by status
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeInactive($query)
    {
        return $query->where('status', 'inactive');
    }

    public function scopeSuspended($query)
    {
        return $query->where('status', 'suspended');
    }
}