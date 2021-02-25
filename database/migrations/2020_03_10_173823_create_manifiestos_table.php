<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateManifiestosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('manifiestos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('linea')->nullable();
            $table->string('buque')->nullable();
            $table->string('viaje')->nullable();
            $table->string('bl')->nullable();
            $table->string('procedencia')->nullable();
            $table->text('comodity')->nullable();
            $table->string('peso')->nullable();
            $table->string('numero')->index();
            $table->smallInteger('tamano')->index();
            $table->string('tipo')->index();
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
        Schema::dropIfExists('manifiestos');
    }
}
