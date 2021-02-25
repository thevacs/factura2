<?php

use App\Models\Banco;
use Illuminate\Database\Seeder;

class BancosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $bancos = collect([
            ['nombre' => '100%BANCO'],
            ['nombre' => 'ABN AMRO BANK'],
            ['nombre' => 'BANCAMIGA BANCO MICROFINANCIERO, C.A.'],
            ['nombre' => 'BANCO ACTIVO BANCO COMERCIAL, C.A.'],
            ['nombre' => 'BANCO AGRICOLA'],
            ['nombre' => 'BANCO BICENTENARIO'],
            ['nombre' => 'BANCO CARONI, C.A. BANCO UNIVERSAL'],
            ['nombre' => 'BANCO CENTRAL DE VENEZUELA.'],
            ['nombre' => 'BANCO DE DESARROLLO DEL MICROEMPRESARIO'],
            ['nombre' => 'BANCO DE VENEZUELA S.A.I.C.A.'],
            ['nombre' => 'BANCO DEL CARIBE C.A.'],
            ['nombre' => 'BANCO DEL PUEBLO SOBERANO C.A.'],
            ['nombre' => 'BANCO DEL TESORO'],
            ['nombre' => 'BANCO ESPIRITO SANTO, S.A.'],
            ['nombre' => 'BANCO EXTERIOR C.A.'],
            ['nombre' => 'BANCO INTERNACIONAL DE DESARROLLO, C.A.'],
            ['nombre' => 'BANCO MERCANTIL C.A.'],
            ['nombre' => 'BANCO NACIONAL DE CREDITO'],
            ['nombre' => 'BANCO OCCIDENTAL DE DESCUENTO.'],
            ['nombre' => 'BANCO PLAZA'],
            ['nombre' => 'BANCO PROVINCIAL BBVA'],
            ['nombre' => 'BANCO VENEZOLANO DE CREDITO S.A.'],
            ['nombre' => 'BANESCO BANCO UNIVERSAL, C.A.'],
            ['nombre' => 'BANCRECER S.A. BANCO DE DESARROLLO'],
            ['nombre' => 'BANFANB'],
            ['nombre' => 'BANGENTE'],
            ['nombre' => 'BANPLUS BANCO COMERCIAL C.A'],
            ['nombre' => 'CITIBANK.'],
            ['nombre' => 'DELSUR BANCO UNIVERSAL'],
            ['nombre' => 'FONDO COMUN'],
            ['nombre' => 'INSTITUTO MUNICIPAL DE CRÉDITO POPULAR'],
            ['nombre' => 'MIBANCO BANCO DE DESARROLLO, C.A.'],
            ['nombre' => 'SOFITASA'],
        ]);

        foreach ($bancos as $banco) {
            Banco::create($banco);
        }
    }
}
