<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMovimientosTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movimientos_transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('account_id');
            $table->integer('instrument_id');
            $table->decimal('monto',12,6)->default(0);
            $table->date('fecha_transaccion')->nullable();
            $table->date('fecha_valor')->nullable();
            $table->integer('movimientos_descripcion_id');
            $table->integer('movimientos_tipo_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('movimientos_transactions');
    }
}
