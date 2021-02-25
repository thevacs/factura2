<?php

use Illuminate\Database\Seeder;
use App\Models\TipoPago;

class TipoPagosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tipos = collect([
            ['nombre' => 'Punto de Venta', 'activo' => true],
            ['nombre' => 'Divisa', 'activo' => true],
            ['nombre' => 'Efectivo', 'activo' => true],
            ['nombre' => 'Transferencia Mismo Banco', 'activo' => true],
            ['nombre' => 'Transferencia Otro Banco', 'activo' => true],
        ]);

        foreach ($tipos as $tipo) {
            TipoPago::create($tipo);
        }
    }
}
