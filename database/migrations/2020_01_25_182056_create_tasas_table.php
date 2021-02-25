<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateTasasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasas', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->string('nombre');
            $table->string('acronimo');
            $table->string('descripcion')->nullable();
            $table->bigInteger('moneda_id')->unsigned();
            $table->decimal('monto', 10, 2);
            $table->date('vigencia_ini');
            $table->date('vigencia_fin');
            $table->timestamps();
            $table->softDeletes();

        });

        // Default data
        DB::table('tasas')->insert([
            ['nombre' => 'Tasa al Transporte Pesado', 'acronimo' => 'T.T.P', 'moneda_id' => 3, 'monto' => 75, 'vigencia_ini' => '2020-01-01', 'vigencia_fin' => '2020-12-31', 'created_at' => now()]
        ]);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasas');
    }
}
