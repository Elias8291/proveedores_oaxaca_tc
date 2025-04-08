<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ContactoSolicitante extends Model
{
    use HasFactory;

    // Nombre de la tabla asociada
    protected $table = 'contactos_solicitante';

    // Atributos que se pueden llenar masivamente
    protected $fillable = [
        'nombre',
        'puesto',
        'telefono',
        'email',
    ];

    // Relación inversa con Solicitante (uno a muchos inverso)
    public function solicitantes()
    {
        return $this->hasMany(Solicitante::class, 'contacto_id');
    }
}