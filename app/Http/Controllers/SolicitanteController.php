<?php

namespace App\Http\Controllers;

use App\Models\Solicitante;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SolicitanteController extends Controller
{
    public function getSolicitanteData(Request $request)
    {
        $user = Auth::user();
        
        if (!$user) {
            return response()->json(['error' => 'Usuario no autenticado'], 401);
        }

        $solicitante = Solicitante::where('user_id', $user->id)->first();
        
        if (!$solicitante) {
            return response()->json(['error' => 'Solicitante no encontrado'], 404);
        }

        return response()->json([
            'curp' => $solicitante->curp,
            'tipo_persona' => $solicitante->tipo_persona,
            'razon_social' => $solicitante->razon_social,
            'email' => $solicitante->email,
            'rfc' => $user->rfc // Assuming RFC is in the User model
        ]);
    }

    
}