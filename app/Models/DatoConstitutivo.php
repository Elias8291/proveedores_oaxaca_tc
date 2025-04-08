<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DatoConstitutivo extends Model
{
    use HasFactory;

    // Nombre de la tabla asociada
    protected $table = 'datos_constitutivos';

    // Atributos que se pueden llenar masivamente
    protected $fillable = [
        'numero_escritura',
        'fecha_constitucion',
        'nombre_notario',
        'estado_id',
        'numero_notario',
        'registro_mercantil',
        'fecha_registro',
        'objeto_social',
    ];

    // Casteo de fechas
    protected $casts = [
        'fecha_constitucion' => 'date',
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
        return $this->hasMany(Solicitante::class, 'dato_constitutivo_id');
    }
}