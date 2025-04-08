<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Solicitante;
use App\Models\User;
use App\Models\Direccion;
use App\Models\Asentamiento;

class SolicitanteSeeder extends Seeder
{
    public function run()
    {
        $user = User::where('email', 'eliasrj824@gmail.com')->first();
        
        if ($user) {
            // Verificar si existe un asentamiento con el código postal 71233
            $asentamiento = Asentamiento::where('codigo_postal', 71233)->first();
            
            if (!$asentamiento) {
                echo "Error: El código postal 71233 no existe en la tabla asentamientos. No se creará la dirección ni el solicitante.\n";
                return; // Detener el seeder aquí
            }

            // Crear la dirección solo si existe el asentamiento
            $direccion = Direccion::updateOrCreate(
                [
                    'codigo_postal' => 71233,
                    'calle' => 'Calle Principal',
                    'numero_exterior' => '45',
                ],
                [
                    'asentamiento_id' => $asentamiento->id, // Vincular si existe
                    'numero_interior' => null,
                    'entre_calle_1' => 'Calle Norte',
                    'entre_calle_2' => 'Calle Sur',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );

            // Crear el solicitante con la dirección
            Solicitante::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'email' => 'eliasrj824@gmail.com',
                    'telefono' => '9511879940',
                    'sitio_web' => null,
                    'razon_social' => 'Elias Abisai Ramos Jacinto',
                    'tipo_persona' => 'Física',
                    'curp' => 'RAJE020226HOCMCLA6',
                    'direccion_id' => $direccion->id,
                    'contacto_id' => null,
                    'representante_legal_id' => null,
                    'dato_constitutivo_id' => null,
                    'estado_revision' => 'Pendiente',
                    'progreso_tramite' => 0,
                    'numero_seccion' => null,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            );
        }
    }
}