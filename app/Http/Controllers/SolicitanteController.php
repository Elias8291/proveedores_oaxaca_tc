<?php
namespace App\Http\Controllers;

use App\Models\Solicitante;
use App\Models\Asentamiento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SolicitanteController extends Controller
{
    public function showRegistrationIndex()
    {
        $user = Auth::user();
        if (!$user) return redirect()->route('login');

        $solicitante = Solicitante::where('user_id', $user->id)->first();
        if ($solicitante->numero_seccion >= 1) {
            return redirect()->route('registration.form1.view');
        }

        return view('registration.terminos_condiciones');
    }

    public function getSolicitanteData(Request $request)
    {
        $user = Auth::user();
        if (!$user) return response()->json([], 401);

        $solicitante = Solicitante::where('user_id', $user->id)->first();
        return response()->json([
            'curp' => $solicitante->curp,
            'tipo_persona' => $solicitante->tipo_persona,
            'razon_social' => $solicitante->razon_social,
            'email' => $solicitante->email,
            'rfc' => $user->rfc
        ]);
    }

    public function proceedToForm1(Request $request)
    {
        $user = Auth::user();
        if (!$user) return redirect()->route('login');

        $request->validate(['terms' => 'required|accepted']);
        $solicitante = Solicitante::where('user_id', $user->id)->first();

        if ($solicitante->numero_seccion < 1) {
            $solicitante->numero_seccion = 1;
            $solicitante->save();
        }
    }

    public function showForm1()
    {
        $user = Auth::user();
        $solicitante = Solicitante::where('user_id', $user->id)->first();
        
        return view('registration.formularios.formularios', [
            'tipo_persona' => $solicitante ? $solicitante->tipo_persona : null
        ]);
    }

    public function getDireccionData(Request $request)
    {
        $user = Auth::user();
        if (!$user) return response()->json([], 401);

        $solicitante = Solicitante::with('direccion.asentamiento.localidad.municipio.estado')
            ->where('user_id', $user->id)->first();
        
        if (!$solicitante || !$solicitante->direccion) {
            return response()->json([]);
        }

        $asentamiento = $solicitante->direccion->asentamiento;
        $codigoPostal = $asentamiento->codigo_postal;

        $asentamientos = $codigoPostal ? Asentamiento::where('codigo_postal', $codigoPostal)
            ->get()
            ->map(fn($a) => [
                'id' => $a->id,
                'nombre' => $a->nombre,
                'tipo_asentamiento' => $a->tipoAsentamiento->nombre ?? '',
                'nombre_completo' => ($a->tipoAsentamiento->nombre ?? '') . ' ' . $a->nombre,
                'municipio' => $a->localidad->municipio->nombre ?? '',
                'estado' => $a->localidad->municipio->estado->nombre ?? '',
                'estado_id' => $a->localidad->municipio->estado->id ?? null
            ]) : [];

        return response()->json([
            'codigo_postal' => $codigoPostal,
            'estado' => $asentamiento->localidad->municipio->estado->nombre ?? '',
            'estado_id' => $asentamiento->localidad->municipio->estado->id ?? null,
            'municipio' => $asentamiento->localidad->municipio->nombre ?? '',
            'colonia' => $asentamiento->nombre ?? '',
            'colonia_id' => $asentamiento->id ?? null,
            'tipo_asentamiento' => $asentamiento->tipoAsentamiento->nombre ?? '',
            'calle' => $solicitante->direccion->calle ?? '',
            'asentamientos' => $asentamientos,
            'estados_disponibles' => collect($asentamientos)->unique('estado_id')->pluck('estado', 'estado_id'),
            'municipios_disponibles' => collect($asentamientos)->unique('municipio')->pluck('municipio')
        ]);
    }
}