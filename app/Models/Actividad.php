<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Actividad extends Model
{
    protected $table = 'actividades';
    protected $fillable = ['nombre', 'sector_id'];

    public function sector()
    {
        return $this->belongsTo(Sector::class, 'sector_id');
    }
}