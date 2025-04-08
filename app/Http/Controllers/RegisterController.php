<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Solicitante;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Smalot\PdfParser\Parser;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'sat_file' => 'required|file|mimes:pdf|max:5120',
            'email' => 'required|email|unique:users,email',
            'tipo_persona' => 'required|in:Física,Moral',
        ]);

        try {
            // Procesar PDF
            $pdfData = $this->processPDF($request->file('sat_file'));
            
            // Validar RFC
            if (empty($pdfData['rfc'])) {
                throw new \Exception('No se pudo extraer el RFC del documento.');
            }

            // Crear usuario
            $user = User::create([
                'name' => $pdfData['nombre'] ?? $pdfData['razon_social'],
                'email' => $validatedData['email'],
                'rfc' => $pdfData['rfc'],
                'password' => Hash::make(Str::random(40)),
                'verification_token' => Str::random(60),
                'status' => 'active',
            ]);

            // Crear solicitante
            $solicitante = Solicitante::create([
                'user_id' => $user->id,
                'email' => $validatedData['email'],
                'razon_social' => $pdfData['razon_social'] ?? $pdfData['nombre'],
                'tipo_persona' => $validatedData['tipo_persona'],
                'curp' => $validatedData['tipo_persona'] === 'Física' ? ($pdfData['curp'] ?? null) : null,
                'estado_revision' => 'Pendiente',
                'progreso_tramite' => 0,
                'numero_seccion' => 0,
            ]);

            // Enviar correo para establecer contraseña
            $user->sendPasswordSetNotification();

            return response()->json([
                'success' => true,
                'message' => 'Registro exitoso. Por favor revisa tu correo para establecer tu contraseña.',
                'redirect' => route('verification.notice')
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error en el registro: ' . $e->getMessage()
            ], 500);
        }
    }

    private function processPDF($file)
    {
        $parser = new Parser();
        $pdf = $parser->parseFile($file->path());
        $text = $pdf->getText();
        
        // Extraer datos del PDF
        $data = [];
        
        // Extraer RFC
        preg_match('/RFC:?\s*([A-ZÑ&]{3,4}\d{6}[A-Z0-9]{3})/i', $text, $rfcMatches);
        $data['rfc'] = $rfcMatches[1] ?? null;
        
        // Extraer Razón Social o Nombre
        preg_match('/NOMBRE(?:\sDEL\sCONTRIBUYENTE)?:\s*([A-ZÀ-ÚÑ&\s]+)/i', $text, $nombreMatches);
        $data['nombre'] = trim($nombreMatches[1] ?? '');
        
        preg_match('/DENOMINACIÓN|RAZÓN SOCIAL:\s*([A-ZÀ-ÚÑ&\s]+)/i', $text, $razonMatches);
        $data['razon_social'] = trim($razonMatches[1] ?? $data['nombre']);
        
        // Extraer CURP (solo para personas físicas)
        preg_match('/CURP:?\s*([A-Z]{4}\d{6}[A-Z]{6}\d{2})/i', $text, $curpMatches);
        $data['curp'] = $curpMatches[1] ?? null;
        
        return $data;
    }
}