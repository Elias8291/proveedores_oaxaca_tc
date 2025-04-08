<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EstadosTableSeeder extends Seeder
{
    public function run()
    {
        $estados = [
            'Aguascalientes',
            'Baja California',
            'Baja California Sur',
            'Campeche',
            'Coahuila de Zaragoza',
            'Colima',
            'Chiapas',
            'Chihuahua',
            'Ciudad de México',
            'Durango',
            'Guanajuato',
            'Guerrero',
            'Hidalgo',
            'Jalisco',
            'México',
            'Michoacán de Ocampo',
            'Morelos',
            'Nayarit',
            'Nuevo León',
            'Oaxaca',
            'Puebla',
            'Querétaro',
            'Quintana Roo',
            'San Luis Potosí',
            'Sinaloa',
            'Sonora',
            'Tabasco',
            'Tamaulipas',
            'Tlaxcala',
            'Veracruz de Ignacio de la Llave',
            'Yucatán',
            'Zacatecas',
        ];

        foreach ($estados as $estado) {
            DB::table('estados')->insert([
                'id_pais' => 103, // Changed from 'pais_id' to 'id_pais'
                'nombre' => $estado,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}