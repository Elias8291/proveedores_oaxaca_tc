<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pais extends Model
{
    use HasFactory;

    // Nombre de la tabla asociada
    protected $table = 'paises';

    // Atributos que se pueden llenar masivamente
    protected $fillable = [
        'nombre',
    ];

    // Relación inversa con Estado (uno a muchos inverso)
    public function estados()
    {
        return $this->hasMany(Estado::class, 'id_pais');
    }
}