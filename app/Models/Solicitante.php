<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Solicitante extends Model
{
    use HasFactory;

    // Nombre de la tabla asociada (opcional si sigue la convención de Laravel)
    protected $table = 'solicitantes';

    // Atributos que se pueden llenar masivamente
    protected $fillable = [
        'user_id',
        'email',
        'telefono',
        'sitio_web',
        'razon_social',
        'tipo_persona',
        'curp',
        'direccion_id',
        'contacto_id',
        'representante_legal_id',
        'dato_constitutivo_id',
        'estado_revision',
        'progreso_tramite',
        'numero_seccion',
    ];

    // Atributos que se castean a tipos específicos
    protected $casts = [
        'tipo_persona' => 'string', // Enum: 'Física', 'Moral'
        'estado_revision' => 'string', // Enum: 'Pendiente', 'En Revision', 'Revisado'
        'progreso_tramite' => 'integer',
        'numero_seccion' => 'integer',
    ];

    // Valores por defecto
    protected $attributes = [
        'telefono' => null,
        'sitio_web' => null,
        'curp' => null,
        'direccion_id' => null,
        'contacto_id' => null,
        'representante_legal_id' => null,
        'dato_constitutivo_id' => null,
        'estado_revision' => 'Pendiente',
        'progreso_tramite' => 0,
        'numero_seccion' => null,
    ];

    // Relación con el modelo User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relación con el modelo Direccion (si existe)
    public function direccion()
    {
        return $this->belongsTo(Direccion::class, 'direccion_id');
    }

    // Relación con el modelo ContactoSolicitante (si existe)
    public function contacto()
    {
        return $this->belongsTo(ContactoSolicitante::class, 'contacto_id');
    }

    // Relación con el modelo RepresentanteLegal (si existe)
    public function representanteLegal()
    {
        return $this->belongsTo(RepresentanteLegal::class, 'representante_legal_id');
    }

    // Relación con el modelo DatoConstitutivo (si existe)
    public function datoConstitutivo()
    {
        return $this->belongsTo(DatoConstitutivo::class, 'dato_constitutivo_id');
    }
}