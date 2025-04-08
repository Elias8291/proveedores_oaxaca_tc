<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Localidad extends Model
{
    use HasFactory;

    // Nombre de la tabla asociada
    protected $table = 'localidades';

    // Atributos que se pueden llenar masivamente
    protected $fillable = [
        'municipio_id',
        'nombre',
    ];

    // Relación con el modelo Municipio
    public function municipio()
    {
        return $this->belongsTo(Municipio::class, 'municipio_id');
    }

    // Relación inversa con Asentamiento (uno a muchos inverso)
    public function asentamientos()
    {
        return $this->hasMany(Asentamiento::class, 'localidad_id');
    }
}