<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Estado extends Model
{
    use HasFactory;

    // Nombre de la tabla asociada
    protected $table = 'estados';

    // Atributos que se pueden llenar masivamente
    protected $fillable = [
        'id_pais',
        'nombre',
    ];

    // Relación con el modelo Pais
    public function pais()
    {
        return $this->belongsTo(Pais::class, 'id_pais');
    }

    // Relación inversa con RepresentanteLegal (uno a muchos inverso)
    public function representantesLegales()
    {
        return $this->hasMany(RepresentanteLegal::class, 'estado_id');
    }

    // Relación inversa con DatoConstitutivo (uno a muchos inverso)
    public function datosConstitutivos()
    {
        return $this->hasMany(DatoConstitutivo::class, 'estado_id');
    }
}