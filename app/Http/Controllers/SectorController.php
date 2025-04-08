<?php
// app/Http/Controllers/SectorController.php
namespace App\Http\Controllers;

use App\Models\Sector;
use App\Models\Actividad;
use Illuminate\Http\Request;

class SectorController extends Controller
{
    public function getSectores()
    {
        $sectores = Sector::orderBy('nombre')->get();
        return response()->json($sectores);
    }

    public function getActividades($sectorId)
    {
        $actividades = Actividad::where('sector_id', $sectorId)
                              ->orderBy('nombre')
                              ->get();
        return response()->json($actividades);
    }
}