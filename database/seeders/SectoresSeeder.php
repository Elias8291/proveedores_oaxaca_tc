<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class SectoresSeeder extends Seeder
{
    public function run()
    {
        $jsonPath = public_path('json/sectores.json');
        $jsonData = File::get($jsonPath);
        $data = json_decode($jsonData, true);
        $sectores = [];
        
        foreach ($data['Hoja1'] as $item) {
            $sectores[] = [
                'nombre' => $item['sector'],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        
        DB::table('sectores')->insert($sectores);
    }
}