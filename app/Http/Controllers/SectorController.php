<?php

namespace App\Http\Controllers;

use App\Models\Sector;
use App\Models\Actividad;
use Illuminate\Http\Request;

class SectorController extends Controller
{
    /**
     * Muestra la vista principal del formulario con los sectores
     */
    public function showRegistrationForm()
    {
        $sectores = Sector::with('actividades')
                        ->orderBy('nombre')
                        ->get();
    
        return view('registration.formularios.formularios', [
            'sectores' => $sectores,
        ]);
    }
    /**
     * Obtiene todos los sectores (para API)
     */
    public function getSectores()
    {
        $sectores = Sector::orderBy('nombre')->get();
        return response()->json([
            'success' => true,
            'data' => $sectores
        ]);
    }

    /**
     * Obtiene las actividades de un sector específico (para API)
     */
    public function getActividadesPorSector($sector)
    {
        $actividades = Actividad::where('sector_id', $sector)
                        ->orderBy('nombre')
                        ->get();
        return response()->json([
            'success' => true,
            'data' => $actividades
        ]);
    }
}