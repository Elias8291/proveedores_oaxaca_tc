<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RepresentanteLegal extends Model
{
    use HasFactory;

    // Nombre de la tabla asociada
    protected $table = 'representantes_legales';

    // Atributos que se pueden llenar masivamente
    protected $fillable = [
        'nombre',
        'numero_escritura',
        'fecha',
        'nombre_notario',
        'numero_notario',
        'estado_id',
        'registro_mercantil',
        'fecha_registro',
    ];

    // Casteo de fechas
    protected $casts = [
        'fecha' => 'date',
        'fecha_registro' => 'date',
    ];

    // Relación con el modelo Estado
    public function estado()
    {
        return $this->belongsTo(Estado::class, 'estado_id');
    }

    // Relación inversa con Solicitante (uno a muchos inverso)
    public function solicitantes()
    {
        return $this->hasMany(Solicitante::class, 'representante_legal_id');
    }
}