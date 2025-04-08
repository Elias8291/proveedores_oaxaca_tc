<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class LocalidadesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Get the JSON file path
        $jsonPath = public_path('json/localidades.json');
        
        // Read and decode the JSON file
        $json = File::get($jsonPath);
        $data = json_decode($json, true);
        
        // Prepare the data for insertion
        $localidades = [];
        foreach ($data['Sheet1'] as $item) {
            $localidades[] = [
                'municipio_id' => $item['municipality_id'],
                'nombre' => $item['name'],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        
        // Insert the data into the localidades table
        DB::table('localidades')->insert($localidades);
    }
}