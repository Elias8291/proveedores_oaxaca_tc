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
        // Solicitante Persona Física (Elias Abisai Ramos Jacinto)
        $userFisica = User::where('email', 'eliasrj824@gmail.com')->first();
        
        if ($userFisica) {
            $asentamiento = Asentamiento::where('codigo_postal', 71233)->first();
            
            if (!$asentamiento) {
                echo "Error: El código postal 71233 no existe en la tabla asentamientos. No se crearán las direcciones ni los solicitantes.\n";
                return;
            }

            $direccionFisica = Direccion::updateOrCreate(
                [
                    'codigo_postal' => 71233,
                    'calle' => 'Calle Principal',
                    'numero_exterior' => '45',
                ],
                [
                    'asentamiento_id' => $asentamiento->id,
                    'numero_interior' => null,
                    'entre_calle_1' => 'Calle Norte',
                    'entre_calle_2' => 'Calle Sur',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );

            Solicitante::updateOrCreate(
                ['user_id' => $userFisica->id],
                [
                    'email' => 'eliasrj824@gmail.com',
                    'telefono' => '9511879940',
                    'sitio_web' => null,
                    'razon_social' => 'Elias Abisai Ramos Jacinto',
                    'tipo_persona' => 'Física',
                    'curp' => 'RAJE020226HOCMCLA6',
                    'direccion_id' => $direccionFisica->id,
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
        } else {
            echo "Error: No se encontró el usuario con email 'eliasrj824@gmail.com'.\n";
        }

        // Solicitante Persona Moral (Radiomóvil Dipsa, S.A. de C.V.)
        $userMoral = User::where('email', 'like', 'telcel%@example.com')->first();
        
        if ($userMoral) {
            $asentamiento = Asentamiento::where('codigo_postal', 71233)->first();
            
            if (!$asentamiento) {
                echo "Error: El código postal 71233 no existe en la tabla asentamientos. No se crearán las direcciones ni los solicitantes.\n";
                return;
            }

            $direccionMoral = Direccion::updateOrCreate(
                [
                    'codigo_postal' => 71233,
                    'calle' => 'Avenida Central',
                    'numero_exterior' => '100',
                ],
                [
                    'asentamiento_id' => $asentamiento->id,
                    'numero_interior' => 'A',
                    'entre_calle_1' => 'Calle Este',
                    'entre_calle_2' => 'Calle Oeste',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );

            Solicitante::updateOrCreate(
                ['user_id' => $userMoral->id],
                [
                    'email' => $userMoral->email,
                    'telefono' => '5551234567',
                    'sitio_web' => 'www.telcel.com',
                    'razon_social' => 'Radiomóvil Dipsa, S.A. de C.V.',
                    'tipo_persona' => 'Moral',
                    'curp' => null, // No aplica para persona moral
                    'direccion_id' => $direccionMoral->id,
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
        } else {
            echo "Error: No se encontró un usuario con email que contenga 'telcel'.\n";
        }
    }
}