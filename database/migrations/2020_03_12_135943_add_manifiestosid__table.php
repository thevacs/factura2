<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddManifiestosidTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('manifiestos_contenedor', function (Blueprint $table) {
            $table->unsignedbigInteger('manifiesto_id')->after('id');
            $table->foreign('manifiesto_id')
                ->references('id')
                ->on('manifiestos')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();

        Schema::table('manifiestos_contenedor', function (Blueprint $table) {
            $table->dropForeign('manifiestos_contenedor_manifiesto_id_foreign');
            $table->dropColumn('manifiesto_id');
        });

        Schema::enableForeignKeyConstraints();

    }
}
