<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AporteSeeder::class);
        $this->call(ImpuestoSeeder::class);
        $this->call(MonedaSeeder::class);
        $this->call(ProductoSeeder::class);
    }
}
