<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Direccion extends Model
{
    use HasFactory;

    // Nombre de la tabla asociada
    protected $table = 'direcciones';

    // Atributos que se pueden llenar masivamente
    protected $fillable = [
        'asentamiento_id',
        'calle',
        'numero_exterior',
        'numero_interior',
        'entre_calle_1',
        'entre_calle_2',
    ];

    // Atributos con valores por defecto
    protected $attributes = [
        'numero_interior' => null,
        'entre_calle_1' => null,
        'entre_calle_2' => null,
    ];

    // Relación con el modelo Asentamiento
    public function asentamiento()
    {
        return $this->belongsTo(Asentamiento::class, 'asentamiento_id');
    }

    // Relación inversa con Solicitante (uno a muchos inverso)
    public function solicitantes()
    {
        return $this->hasMany(Solicitante::class, 'direccion_id');
    }
}