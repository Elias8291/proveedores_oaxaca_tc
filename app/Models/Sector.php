<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sector extends Model
{
    protected $table = 'sectores';
    protected $fillable = ['nombre'];

    public function actividades()
    {
        return $this->hasMany(Actividad::class, 'sector_id');
    }
}