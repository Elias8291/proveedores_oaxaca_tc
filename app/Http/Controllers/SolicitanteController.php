<?php

namespace App\Http\Controllers;

use App\Models\Solicitante;
use App\Models\Asentamiento;
use App\Models\User;
use App\Models\Direccion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SolicitanteController extends Controller
{
    // Registra un nuevo solicitante con sus datos básicos, dirección y archivo SAT
    public function register(Request $request)
    {
        try {
            $request->validate([
                'sat_file' => 'required|file|mimes:pdf|max:5120',
                'email' => 'required|email|unique:users,email',
                'nombre' => 'required|string|max:255',
                'rfc' => 'required|string|max:255|unique:users,rfc',
                'tipo_persona' => 'required|in:Física,Moral',
                'codigo_postal' => 'required|integer',
                'curp' => 'nullable|string|regex:/^[A-Z0-9]{18}$/',
            ], [
                'sat_file.required' => 'El archivo SAT es obligatorio.',
                'sat_file.mimes' => 'El archivo SAT debe ser un PDF.',
                'sat_file.max' => 'El archivo SAT no debe exceder 5MB.',
                'email.required' => 'El correo electrónico es obligatorio.',
                'email.email' => 'El correo electrónico debe ser válido.',
                'email.unique' => 'El correo electrónico ya está registrado. Por favor, usa otro correo.',
                'nombre.required' => 'El nombre es obligatorio.',
                'nombre.max' => 'El nombre no debe exceder 255 caracteres.',
                'rfc.required' => 'El RFC es obligatorio.',
                'rfc.unique' => 'El RFC ya está registrado. No puedes registrar este RFC nuevamente.',
                'tipo_persona.required' => 'El tipo de persona es obligatorio.',
                'tipo_persona.in' => 'El tipo de persona debe ser Física o Moral.',
                'codigo_postal.required' => 'El código postal es obligatorio.',
                'codigo_postal.integer' => 'El código postal debe ser un número entero.',
                'curp.string' => 'El CURP debe ser una cadena de texto.',
                'curp.regex' => 'El CURP debe ser una cadena alfanumérica de 18 caracteres.',
            ]);

            DB::beginTransaction();

            $user = new User();
            $user->name = $request->nombre;
            $user->email = $request->email;
            $user->password = Hash::make('ZDYPNFHUSCED');
            $user->rfc = $request->rfc;
            $user->ultimo_acceso = null;
            $user->status = 'active';
            $user->save();

            $user->assignRole('solicitante');

            $direccion = new Direccion();
            $direccion->codigo_postal = $request->codigo_postal;
            $direccion->save();

            $solicitante = new Solicitante();
            $solicitante->user_id = $user->id;
            $solicitante->email = $request->email;
            $solicitante->telefono = null;
            $solicitante->sitio_web = null;
            $solicitante->razon_social = $request->tipo_persona === 'Moral' ? $request->nombre : $request->nombre;
            $solicitante->tipo_persona = $request->tipo_persona;
            $solicitante->curp = $request->tipo_persona === 'Física' && $request->curp ? $request->curp : null;
            $solicitante->direccion_id = $direccion->id;
            $solicitante->contacto_id = null;
            $solicitante->representante_legal_id = null;
            $solicitante->dato_constitutivo_id = null;
            $solicitante->estado_revision = 'Pendiente';
            $solicitante->progreso_tramite = 0;
            $solicitante->numero_seccion = 0;
            $solicitante->save();

            DB::commit();

            Log::info('User registered successfully', [
                'user_id' => $user->id,
                'email' => $user->email,
                'rfc' => $user->rfc,
                'curp' => $solicitante->curp,
                'role' => 'solicitante',
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Registro exitoso. Por favor, inicia sesión para continuar.',
                'redirect' => route('login'),
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            $errors = $e->errors();
            $message = 'Errores de validación.';

            if (isset($errors['rfc']) && in_array('El RFC ya está registrado. No puedes registrar este RFC nuevamente.', $errors['rfc'])) {
                $message = 'El RFC ya está registrado. No puedes registrar este RFC nuevamente.';
            } elseif (isset($errors['email']) && in_array('El correo electrónico ya está registrado. Por favor, usa otro correo.', $errors['email'])) {
                $message = 'El correo electrónico ya está registrado. Por favor, usa otro correo.';
            } elseif (isset($errors['curp'])) {
                $message = 'El CURP proporcionado no es válido.';
            }

            return response()->json([
                'success' => false,
                'message' => $message,
                'errors' => $errors,
            ], 422);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error during registration: ' . $e->getMessage(), [
                'request' => $request->all(),
                'trace' => $e->getTraceAsString(),
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Error al registrar: ' . $e->getMessage(),
            ], 500);
        }
    }


    

    // Determina la vista inicial de registro o redirige según el estado del solicitante
    public function showRegistrationIndex()
    {
        $user = Auth::user();
        if (!$user) return redirect()->route('login');
    
        if ($user->hasRole('revisor_1')) {
            return redirect()->route('registration.formularios.formularios');
        }
    
        $solicitante = Solicitante::where('user_id', $user->id)->first();
        if ($solicitante && $solicitante->numero_seccion >= 1) {
            return redirect()->route('registration.formularios.formularios');
        }
    
        return view('registration.terminos_condiciones');
    }

    // Proporciona los datos del solicitante autenticado para su uso en formularios
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

    // Valida la aceptación de términos y avanza al primer formulario
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

    // Muestra el primer formulario de registro con datos del solicitante
    public function showForm1()
    {
        $user = Auth::user();
        $solicitante = Solicitante::where('user_id', $user->id)->first();

        return view('registration.formularios.formularios', [
            'tipo_persona' => $solicitante ? $solicitante->tipo_persona : null
        ]);
    }

    // Obtiene los datos de dirección del solicitante, incluyendo información geográfica
   // Obtiene los datos de dirección del solicitante o basados en un código postal proporcionado
public function getDireccionData(Request $request)
{
    $user = Auth::user();
    if (!$user) {
        Log::warning('Intento de acceso a getDireccionData sin autenticación', ['ip' => $request->ip()]);
        return response()->json(['error' => 'Usuario no autenticado'], 401);
    }

    $codigoPostal = null;
    $solicitante = null;

    if ($user->hasRole('revisor_1')) {
        // For revisor_1, use the provided codigo_postal
        $request->validate([
            'codigo_postal' => 'nullable|digits:5',
        ], [
            'codigo_postal.digits' => 'El código postal debe contener exactamente 5 dígitos.',
        ]);

        $codigoPostal = $request->input('codigo_postal');
        if (!$codigoPostal) {
            return response()->json([
                'codigo_postal' => '',
                'estado' => '',
                'municipio' => '',
                'asentamientos' => []
            ]);
        }
    } else {
        // For solicitante, use the stored codigo_postal
        $solicitante = Solicitante::with('direccion')->where('user_id', $user->id)->first();
        if (!$solicitante) {
            Log::error('Solicitante no encontrado para user_id: ' . $user->id);
            return response()->json(['error' => 'Solicitante no encontrado'], 404);
        }

        if (!$solicitante->direccion || !$solicitante->direccion->codigo_postal) {
            return response()->json([
                'codigo_postal' => '',
                'estado' => '',
                'municipio' => '',
                'asentamientos' => []
            ]);
        }

        $codigoPostal = $solicitante->direccion->codigo_postal;
    }

    $data = DB::table('asentamientos')
        ->join('localidades', 'asentamientos.localidad_id', '=', 'localidades.id')
        ->join('municipios', 'localidades.municipio_id', '=', 'municipios.id')
        ->join('estados', 'municipios.estado_id', '=', 'estados.id')
        ->join('paises', 'estados.id_pais', '=', 'paises.id')
        ->where('asentamientos.codigo_postal', $codigoPostal)
        ->select(
            'paises.nombre as pais',
            'estados.nombre as estado',
            'municipios.nombre as municipio',
            DB::raw('GROUP_CONCAT(asentamientos.id) as asentamiento_ids'),
            DB::raw('GROUP_CONCAT(asentamientos.nombre) as asentamientos')
        )
        ->groupBy('paises.nombre', 'estados.nombre', 'municipios.nombre')
        ->first();

    if (!$data) {
        return response()->json([
            'codigo_postal' => $codigoPostal,
            'estado' => '',
            'municipio' => '',
            'asentamientos' => []
        ]);
    }

    $asentamientoIds = explode(',', $data->asentamiento_ids);
    $asentamientos = explode(',', $data->asentamientos);

    $asentamientosList = array_map(function ($id, $nombre) {
        return ['id' => $id, 'nombre' => $nombre];
    }, $asentamientoIds, $asentamientos);

    return response()->json([
        'codigo_postal' => $codigoPostal,
        'estado' => $data->estado,
        'municipio' => $data->municipio,
        'asentamientos' => $asentamientosList
    ]);
}

    // Procesa la aceptación de términos y condiciones para avanzar en el registro
    public function acceptTerms(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        $request->validate([
            'terms' => 'required|accepted',
        ], [
            'terms.accepted' => 'Debes aceptar los términos y condiciones para continuar.',
        ]);

        $solicitante = Solicitante::firstOrCreate(
            ['user_id' => $user->id],
            ['numero_seccion' => 0, 'tipo_persona' => 'Física']
        );

        if ($solicitante->numero_seccion < 1) {
            $solicitante->numero_seccion = 1;
            $solicitante->save();
        }

        return redirect()->route('registration.formularios.formularios');
    }
}