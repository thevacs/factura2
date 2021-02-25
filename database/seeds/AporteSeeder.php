<?php

use App\Aporte;
use Illuminate\Database\Seeder;

class AporteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Aporte::create([
            'nombre' => 'Aporte Social por uso superficial de vias terrestres del Estado',
            'acronimo' => 'ASSVT',
            'descripcion' => 'Aporte Social por uso superficial de vias terrestres del Estado',
            'moneda_id' => '2',
            'valor' => '100',
        ]);
    }
}
