<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class MunicipioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Get the JSON file path
        $jsonPath = public_path('json/municipios.json');
        
        // Read and decode the JSON file
        $json = File::get($jsonPath);
        $data = json_decode($json, true);
        
        // Check if the Sheet1 key exists and get the municipalities
        if (isset($data['Sheet1'])) {
            $municipalities = $data['Sheet1'];
            
            // Insert each municipality into the database
            foreach ($municipalities as $municipality) {
                DB::table('municipios')->insert([
                    'estado_id' => $municipality['state_id'],
                    'nombre' => $municipality['name'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}