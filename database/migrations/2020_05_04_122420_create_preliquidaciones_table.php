<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePreliquidacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('preliquidaciones', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('cliente_id');
            $table->bigInteger('user_id');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('preliquidacion_detalles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('preliquidacion_id');
            $table->bigInteger('item');
            $table->smallInteger('cantidad')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('preliquidaciones');
        Schema::dropIfExists('preliquidacion_detalles');

    }
}
