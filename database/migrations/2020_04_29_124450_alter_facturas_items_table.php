<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterFacturasItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('facturas_items', function (Blueprint $table) {
            $table->renameColumn('producto_id', 'inventario_id');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('facturas_items', function (Blueprint $table) {
            $table->renameColumn('inventario_id', 'producto_id');
        });

    }
}
