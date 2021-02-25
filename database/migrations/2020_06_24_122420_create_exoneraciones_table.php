<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExoneracionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exoneraciones', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('cliente_id');
            $table->string('base_value');
            $table->bigInteger('user_id');
            $table->bigInteger('aporte_id');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('exoneracion_detalles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('exoneracion_id');
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
        Schema::dropIfExists('exoneraciones');
        Schema::dropIfExists('exoneracion_detalles');

    }
}
