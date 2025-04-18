<?php

namespace Database\Seeders;

use App\Models\Solicitante;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call(UserSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(PaisSeeder::class);
        $this->call(EstadosTableSeeder::class);
        $this->call(MunicipioSeeder::class);
        $this->call(LocalidadesSeeder::class);
        $this->call(TiposAsentamientoSeeder::class);
        $this->call(AsentamientosSeeder::class);
        $this->call(SectoresSeeder::class);
        $this->call(ActividadesSeeder::class);
        $this->call(SolicitanteSeeder::class);
    }
}