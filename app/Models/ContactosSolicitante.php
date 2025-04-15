<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactosSolicitante extends Model
{
    protected $table = 'contactos_solicitante';
    protected $fillable = ['nombre', 'puesto', 'telefono', 'email', 'created_at', 'updated_at'];
}