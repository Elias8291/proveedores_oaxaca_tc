<?php

namespace App\Http\Controllers;

use App\Models\Solicitante;
use App\Models\Asentamiento;
use App\Models\User;
use App\Models\Direccion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SolicitanteController extends Controller
{
    // Registra un nuevo solicitante, creando un usuario, dirección y registro de solicitante, y autentica al usuario.
    public function register(Request $request)
    {
        try {
            // Validate request with custom error messages
            $request->validate([
                'sat_file' => 'required|file|mimes:pdf|max:5120',
                'email' => 'required|email|unique:users,email',
                'nombre' => 'required|string|max:255',
                'rfc' => 'required|string|max:255|unique:users,rfc',
                'tipo_persona' => 'required|in:Física,Moral',
                'codigo_postal' => 'required|integer',
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
            ]);
    
            DB::beginTransaction();
    
            // Create user
            $user = new User();
            $user->name = $request->nombre;
            $user->email = $request->email;
            $user->password = Hash::make(Str::random(16)); // Temporary password
            $user->rfc = $request->rfc;
            $user->ultimo_acceso = null;
            $user->status = 'active';
            $user->save();
    
            // Create address
            $direccion = new Direccion();
            $direccion->codigo_postal = $request->codigo_postal;
            $direccion->save();
    
            // Create solicitante
            $solicitante = new Solicitante();
            $solicitante->user_id = $user->id;
            $solicitante->email = $request->email;
            $solicitante->telefono = null;
            $solicitante->sitio_web = null;
            $solicitante->razon_social = $request->tipo_persona === 'Moral' ? $request->nombre : $request->nombre;
            $solicitante->tipo_persona = $request->tipo_persona;
            $solicitante->curp = null;
            $solicitante->direccion_id = $direccion->id;
            $solicitante->contacto_id = null;
            $solicitante->representante_legal_id = null;
            $solicitante->dato_constitutivo_id = null;
            $solicitante->estado_revision = 'Pendiente';
            $solicitante->progreso_tramite = 0;
            $solicitante->numero_seccion = 0;
            $solicitante->save();
    
            DB::commit();
    
            // Log successful registration
            Log::info('User registered successfully', [
                'user_id' => $user->id,
                'email' => $user->email,
                'rfc' => $user->rfc,
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
    
            // Customize message for duplicate RFC or email
            if (isset($errors['rfc']) && in_array('El RFC ya está registrado. No puedes registrar este RFC nuevamente.', $errors['rfc'])) {
                $message = 'El RFC ya está registrado. No puedes registrar este RFC nuevamente.';
            } elseif (isset($errors['email']) && in_array('El correo electrónico ya está registrado. Por favor, usa otro correo.', $errors['email'])) {
                $message = 'El correo electrónico ya está registrado. Por favor, usa otro correo.';
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
    // Muestra la página inicial de registro o redirige según el progreso del solicitante.
    public function showRegistrationIndex()
    {
        $user = Auth::user();
        if (!$user) return redirect()->route('login');

        $solicitante = Solicitante::where('user_id', $user->id)->first();
        if ($solicitante && $solicitante->numero_seccion >= 1) {
            return redirect()->route('registration.formularios.formularios');
        }

        return view('registration.terminos_condiciones');
    } 

    // Obtiene los datos del solicitante autenticado para su uso en formularios.
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

    // Valida la aceptación de términos y avanza el progreso del solicitante al formulario 1.
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

    // Muestra el formulario 1 de registro con datos del solicitante autenticado.
    public function showForm1()
    {
        $user = Auth::user();
        $solicitante = Solicitante::where('user_id', $user->id)->first();

        return view('registration.formularios.formularios', [
            'tipo_persona' => $solicitante ? $solicitante->tipo_persona : null
        ]);
    }

    // Obtiene los datos de dirección del solicitante, incluyendo asentamientos y detalles geográficos.
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

    // Valida la aceptación de términos y condiciones y avanza al formulario de registro.
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