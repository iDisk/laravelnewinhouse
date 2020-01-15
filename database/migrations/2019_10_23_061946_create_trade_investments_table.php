<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTradeInvestmentsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trade_investments', function (Blueprint $table)
        {
            $table->increments('id');
            $table->string('ticket');
            $table->integer('account_id');
            $table->date('fecha');
            $table->enum('tipo', ['dr', 'cr'])->default('dr');
            $table->string('transaction');
            $table->date('fecha_vencimiento');
            $table->decimal('monto', 12, 4)->default(0);
            $table->decimal('nav', 12, 4)->default(0);
            $table->decimal('precio', 12, 4)->default(0);
            $table->decimal('riesgo', 12, 4)->default(0);
            $table->decimal('contratos', 12, 4)->default(0);
            $table->decimal('exposicion', 12, 4)->default(0);
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
        Schema::dropIfExists('trade_investments');
    }

}
