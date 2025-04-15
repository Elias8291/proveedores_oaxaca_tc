<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActividadesSolicitante extends Model
{
    protected $table = 'actividades_solicitante';
    protected $fillable = ['solicitante_id', 'actividad_id', 'created_at', 'updated_at'];
}