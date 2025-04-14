<?php

namespace App\Http\Controllers;

use App\Models\Estado;
use Illuminate\Http\Request;

class EstadoController extends Controller
{
    /**
     * Obtiene todos los estados para usar en formularios
     */
    public function getEstadosForForm()
    {
        $estados = Estado::orderBy('nombre', 'asc')->get();
        return response()->json($estados);
    }
}