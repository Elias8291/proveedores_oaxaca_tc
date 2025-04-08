<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Asentamiento extends Model
{
    use HasFactory;

    // Nombre de la tabla asociada
    protected $table = 'asentamientos';

    // Atributos que se pueden llenar masivamente
    protected $fillable = [
        'nombre',
        'codigo_postal',
        'localidad_id',
        'tipo_asentamiento_id',
    ];

    // Casteo de tipos
    protected $casts = [
        'codigo_postal' => 'integer',
    ];

    // Relación con el modelo Localidad
    public function localidad()
    {
        return $this->belongsTo(Localidad::class, 'localidad_id');
    }

    // Relación con el modelo TipoAsentamiento
    public function tipoAsentamiento()
    {
        return $this->belongsTo(TipoAsentamiento::class, 'tipo_asentamiento_id');
    }

    // Relación inversa con Direccion (uno a muchos inverso)
    public function direcciones()
    {
        return $this->hasMany(Direccion::class, 'asentamiento_id');
    }
}