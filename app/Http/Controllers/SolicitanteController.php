<?php
namespace App\Http\Controllers;

use App\Models\Solicitante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SolicitanteController extends Controller
{
    // Muestra página inicial o redirige según estado
    public function showRegistrationIndex()
    {
        $user = Auth::user();
        if (!$user) return redirect()->route('login');

        $solicitante = Solicitante::where('user_id', $user->id)->first();
        if ($solicitante->numero_seccion >= 1) {
            return redirect()->route('registration.formularios.formularios');
        }

        return view('registration.terminos_condiciones');
    }

    // Devuelve datos del solicitante en JSON
    public function getSolicitanteData(Request $request)
    {
        $user = Auth::user();
        if (!$user) return response()->json([], 401);
    
        $solicitante = Solicitante::where('user_id', $user->id)->first();
        
        $data = [
            'tipo_persona' => $solicitante->tipo_persona,
            'razon_social' => $solicitante->razon_social,
            'email' => $solicitante->email,
            'rfc' => $user->rfc
        ];
        
        if ($solicitante->tipo_persona == 'Física') {
            $data['curp'] = $solicitante->curp;
        }
        
        return response()->json($data);
    }

    // Avanza al formulario 1 tras aceptar términos
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

    // Muestra formulario 1
    public function showForm1()
    {
        $user = Auth::user();
        $solicitante = Solicitante::where('user_id', $user->id)->first();
        
        return view('registration.formularios.formularios', [
            'tipo_persona' => $solicitante ? $solicitante->tipo_persona : null
        ]);
    }
}