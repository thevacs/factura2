<?php

use App\Moneda;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MonedaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $monedas = collect([
            [
                'nombre' => 'Bolivar Soberano',
                'codigo' => 'BS',
                'simbolo' => 'Bs',
                'valor' => '1',
            ],
            [
                'nombre' => 'Dólar Estadounidense',
                'codigo' => 'USD',
                'simbolo' => '$',
                'valor' => '176538.04',
            ],
            [
                'nombre' => 'Euro',
                'codigo' => 'EUR',
                'simbolo' => '€',
                'valor' => '189002.63',
            ],
            [
                'nombre' => 'Petro',
                'codigo' => 'PTR',
                'simbolo' => '₽',
                'valor' => '0',
            ],
        ]);

        DB::table('monedas')->truncate();

        foreach ($monedas as $key => $value) {
            Moneda::create($value);
        }
    }
}
