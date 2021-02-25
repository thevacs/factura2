<?php

use App\Impuesto;
use Illuminate\Database\Seeder;

class ImpuestoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Impuesto::create([
            'nombre' => 'Impuesto al Valor Agregado',
            'acronimo' => 'I.V.A.',
            'descripcion' => 'Impuesto al Valor Agregado',
            'valor' => 16,
            'vigencia_ini' => '2020-03-29',
            'vigencia_fin' => '2020-12-31',
        ]);
    }
}
