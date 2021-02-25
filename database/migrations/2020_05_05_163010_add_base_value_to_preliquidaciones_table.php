<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBaseValueToPreliquidacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('preliquidaciones', function (Blueprint $table) {
            $table->bigInteger('aporte_id')->after('user_id');
            $table->decimal('base_value', 10, 2)->after('user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('preliquidaciones', function (Blueprint $table) {
            $table->dropColumn(['base_value', 'aporte_id']);
        });
    }
}
