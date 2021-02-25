<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFacturasItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facturas_items', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->bigInteger('factura_id')->unsigned();
            $table->bigInteger('producto_id')->unsigned();
            $table->string('tags')->nullable();
            $table->integer('cantidad');
            $table->decimal('precio',10, 2);
            $table->decimal('subtotal', 10, 2);
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
        Schema::dropIfExists('facturas_items');
    }
}
