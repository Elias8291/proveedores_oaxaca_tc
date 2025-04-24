<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActividadSolicitante extends Model
{
    protected $table = 'actividades_solicitante';

    protected $fillable = [
        'solicitante_id',
        'actividad_id',
    ];

    /**
     * Relación con el modelo Solicitante.
     * Una actividad solicitante pertenece a un solicitante.
     */
    public function solicitante()
    {
        return $this->belongsTo(Solicitante::class, 'solicitante_id');
    }

    /**
     * Relación con el modelo Actividad.
     * Una actividad solicitante pertenece a una actividad.
     */
    public function actividad()
    {
        return $this->belongsTo(Actividad::class, 'actividad_id');
    }
}