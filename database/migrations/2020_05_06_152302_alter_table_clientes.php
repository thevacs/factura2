<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableClientes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clientes', function (Blueprint $table) {
            $table->string('contacto')->nullable()->after('direccion');
            $table->string('telefono1')->nullable()->after('contacto');
            $table->string('telefono2')->nullable()->after('telefono1');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('clientes', function (Blueprint $table) {
            $table->dropColumn('contacto');
            $table->dropColumn('telefono1');
            $table->dropColumn('telefono2');
        });
    }
}
