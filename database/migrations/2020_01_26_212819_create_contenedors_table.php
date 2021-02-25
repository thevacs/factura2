<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContenedorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contenedors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('numero',11);
            $table->smallInteger('tamano');
            $table->string('tipo',2);
            $table->string('descripcion');
            $table->string('iso',4);
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
        Schema::dropIfExists('contenedors');
    }
}
