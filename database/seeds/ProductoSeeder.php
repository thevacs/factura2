<?php

use App\Producto;
use Illuminate\Database\Seeder;

class ProductoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $productos = [
            [
                "id" => 1,
                "nombre" => "Contenedor",
                "servicio" => 0,
                "tamano" => null,
                "tipo" => null,
                "moneda_id" => 2,
                "costo" => 0.00,
                "base1" => 1.00,
                "base2" => 1.00,
                "base3" => 1.00,
                "aporte" => 1,
                "iva" => 0,
            ],
            [
                "id" => 2,
                "nombre" => "Aporte Social por uso superficial de vias terrestres del Estado",
                "servicio" => 0,
                "tamano" => null,
                "tipo" => null,
                "moneda_id" => 2,
                "costo" => 100.00,
                "base1" => 1.00,
                "base2" => 1.00,
                "base3" => 1.00,
                "aporte" => 0,
                "iva" => 0,
            ],
            [
                "id" => 3,
                "nombre" => "Bioseguridad Ozonificación",
                "servicio" => 1,
                "tamano" => null,
                "tipo" => null,
                "moneda_id" => 2,
                "costo" => 50.00,
                "base1" => 1.00,
                "base2" => 1.00,
                "base3" => 1.00,
                "aporte" => 0,
                "iva" => 1,
            ],
            [
                "id" => 4,
                "nombre" => "Bioseguridad Desinfección",
                "servicio" => 1,
                "tamano" => null,
                "tipo" => null,
                "moneda_id" => 2,
                "costo" => 30.00,
                "base1" => 1.00,
                "base2" => 1.00,
                "base3" => 1.00,
                "aporte" => 0,
                "iva" => 1,
            ],
        ];

        foreach ($productos as $key => $value) {
            Producto::create($value);
        }
    }
}