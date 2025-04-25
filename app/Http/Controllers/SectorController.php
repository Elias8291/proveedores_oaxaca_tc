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




    public function storeFormulario1(Request $request)
    {
        $user = Auth::user();
        $isRevisor = $user->hasRole('revisor_1');

        // Define validation rules
        $rules = [
            'tipo_persona' => ['required', 'in:Física,Moral'],
            'rfc' => ['required', 'string', 'size:12,13', 'regex:/^[A-Z0-9]+$/'],
            'razon_social' => ['required', 'string', 'max:100', 'regex:/^[A-Za-z\s&.,0-9]+$/'],
            'correo_electronico' => ['required', 'email', 'max:255'],
            'contacto_telefono' => ['required', 'string', 'size:10', 'regex:/^[0-9]{10}$/'],
            'contacto_web' => ['nullable', 'url', 'max:255'],
            'contacto_nombre' => ['required', 'string', 'max:40', 'regex:/^[A-Za-z\s]+$/'],
            'contacto_cargo' => ['required', 'string', 'max:50', 'regex:/^[A-Za-z\s]+$/'],
            'contacto_correo' => ['required', 'email', 'max:255'],
            'contacto_telefono_2' => ['required', 'string', 'size:10', 'regex:/^[0-9]{10}$/'],
            'actividades' => ['required', 'array', 'min:1'],
            'actividades.*' => ['exists:bs_p.actividades,id'],
        ];

        // Add CURP validation for Física
        if ($request->input('tipo_persona') === 'Física') {
            $rules['curp'] = ['required', 'string', 'size:18', 'regex:/^[A-Z0-9]+$/'];
        }

        // Add file validation for revisor_1
        if ($isRevisor) {
            $rules['constancia_upload'] = ['required', 'file', 'mimes:pdf', 'max:5120']; // 5MB max
        }

        // Validate the request
        $validator = Validator::make($request->all(), $rules, [
            'tipo_persona.required' => 'Debe seleccionar Física o Moral.',
            'rfc.required' => 'El RFC es obligatorio.',
            'rfc.size' => 'El RFC debe tener 12 o 13 caracteres.',
            'razon_social.required' => 'La razón social es obligatoria.',
            'correo_electronico.required' => 'El correo electrónico es obligatorio.',
            'contacto_telefono.required' => 'El teléfono de contacto es obligatorio.',
            'contacto_web.url' => 'La URL debe ser válida.',
            'contacto_nombre.required' => 'El nombre del contacto es obligatorio.',
            'contacto_cargo.required' => 'El cargo del contacto es obligatorio.',
            'contacto_correo.required' => 'El correo del contacto es obligatorio.',
            'contacto_telefono_2.required' => 'El segundo teléfono de contacto es obligatorio.',
            'actividades.required' => 'Debe seleccionar al menos una actividad.',
            'curp.required' => 'El CURP es obligatorio para personas físicas.',
            'constancia_upload.required' => 'Debe subir la Constancia de Situación Fiscal.',
            'constancia_upload.mimes' => 'El archivo debe ser un PDF.',
            'constancia_upload.max' => 'El archivo no debe exceder 5MB.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            // Start a database transaction
            return DB::transaction(function () use ($request, $user, $isRevisor) {
                // Handle file upload for revisor_1
                $constanciaPath = null;
                if ($isRevisor && $request->hasFile('constancia_upload')) {
                    $constanciaPath = $request->file('constancia_upload')->store('constancias', 'public');
                }

                // Create or update user (for revisor_1)
                if ($isRevisor) {
                    $user = User::create([
                        'rfc' => $request->input('rfc'),
                        'email' => $request->input('correo_electronico'),
                        'name' => $request->input('razon_social'),
                        'password' => bcrypt(str_random(16)), // Temporary password
                        'status' => 'active',
                    ]);
                }

                // Create or update solicitante
                $solicitante = Solicitante::updateOrCreate(
                    ['user_id' => $user->id],
                    [
                        'email' => $request->input('correo_electronico'),
                        'telefono' => $request->input('contacto_telefono'),
                        'sitio_web' => $request->input('contacto_web'),
                        'razon_social' => $request->input('razon_social'),
                        'tipo_persona' => $request->input('tipo_persona'),
                        'curp' => $request->input('tipo_persona') === 'Física' ? $request->input('curp') : null,
                        'estado_revision' => 'Pendiente',
                        'progreso_tramite' => 25, // Example: 25% for completing Form 1
                    ]
                );

                // Create contact
                $contacto = ContactoSolicitante::create([
                    'nombre' => $request->input('contacto_nombre'),
                    'puesto' => $request->input('contacto_cargo'),
                    'telefono' => $request->input('contacto_telefono_2'),
                    'email' => $request->input('contacto_correo'),
                ]);

                // Update solicitante with contact ID
                $solicitante->contacto_id = $contacto->id;
                $solicitante->save();

                // Sync actividades
                $actividades = $request->input('actividades', []);
                $actividadesData = array_map(fn($actividadId) => ['actividad_id' => $actividadId], $actividades);
                ActividadSolicitante::where('solicitante_id', $solicitante->id)->delete();
                foreach ($actividadesData as $actividad) {
                    ActividadSolicitante::create([
                        'solicitante_id' => $solicitante->id,
                        'actividad_id' => $actividad['actividad_id'],
                    ]);
                }

                return response()->json([
                    'success' => true,
                    'message' => 'Datos guardados correctamente.',
                    'solicitante_id' => $solicitante->id,
                ]);
            });
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al guardar los datos: ' . $e->getMessage(),
            ], 500);
        }
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