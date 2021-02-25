<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTipoPago1FacturasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('facturas', function (Blueprint $table) {
            $table->unsignedbigInteger('tipo_pago_id1')->nullable()->after('tipo_pago_id');
            $table->unsignedbigInteger('tipo_pago_id2')->nullable()->after('tipo_pago_id1');

            $table->foreign('tipo_pago_id1')
                ->references('id')
                ->on('tipo_pagos');
                
            $table->foreign('tipo_pago_id2')
                ->references('id')
                ->on('tipo_pagos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
