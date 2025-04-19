<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Notifications\PasswordSetupNotification;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable, HasRoles;

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

    // Sobrescribir el método notify para evitar interacciones con password_reset_tokens
    public function notify($instance)
    {
        return $this->notifyNow($instance);
    }

    // Personalizar la notificación de verificación de correo
    public function sendEmailVerificationNotification()
    {
        $this->notify(new PasswordSetupNotification($this->verification_token));
    }

    // Método para enviar la notificación de configuración de contraseña
    public function sendPasswordSetNotification()
    {
        $this->notify(new PasswordSetupNotification($this->verification_token));
    }

    // Relación con Solicitante
    public function solicitante()
    {
        return $this->hasOne(Solicitante::class, 'user_id');
    }

    // Métodos auxiliares para el estado
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

    // Scopes para consultar por estado
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