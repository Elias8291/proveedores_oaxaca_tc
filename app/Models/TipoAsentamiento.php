<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TipoAsentamiento extends Model
{
    use HasFactory;

    // Nombre de la tabla asociada
    protected $table = 'tipos_asentamiento';

    // Atributos que se pueden llenar masivamente
    protected $fillable = [
        'nombre',
    ];

    // Relación inversa con Asentamiento (uno a muchos inverso)
    public function asentamientos()
    {
        return $this->hasMany(Asentamiento::class, 'tipo_asentamiento_id');
    }
}