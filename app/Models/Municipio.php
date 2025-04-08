<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Municipio extends Model
{
    use HasFactory;

    // Nombre de la tabla asociada
    protected $table = 'municipios';

    // Atributos que se pueden llenar masivamente
    protected $fillable = [
        'estado_id',
        'nombre',
    ];

    // Relación con el modelo Estado
    public function estado()
    {
        return $this->belongsTo(Estado::class, 'estado_id');
    }

    // Relación inversa con Localidad (uno a muchos inverso)
    public function localidades()
    {
        return $this->hasMany(Localidad::class, 'municipio_id');
    }
}