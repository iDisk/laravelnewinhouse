<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('account_id');
            $table->integer('transaction_type_id');
            $table->integer('instrument_id');
            $table->integer('item_id');
            $table->integer('leverage_id');
            $table->integer('commission_fee_id');
            $table->string('ticket');
            $table->decimal('initial_capital',10,2)->default(0);
            $table->date('opening_date');
            $table->date('closing_date');
            $table->time('opening_time');
            $table->time('closing_time');
            $table->decimal('opening_price',12,6)->default(0);
            $table->decimal('closing_price',12,6)->default(0);
            $table->decimal('conversion_opening',12,6)->default(0);
            $table->decimal('conversion_closing',12,6)->default(0);
            $table->decimal('spread',12,6)->default(0);
            $table->decimal('financial_exhibition',12,6)->default(0);
            $table->decimal('stop_loss',12,6)->default(0);
            $table->decimal('commission',12,6)->default(0);
            $table->integer('contracts');
            $table->decimal('gross_profit',12,6)->default(0);
            $table->decimal('facial_value',12,2)->default(0);
            $table->decimal('net_result',12,6)->default(0);
            $table->decimal('warranty',12,2)->default(0);
            $table->decimal('final_capital_client',12,6)->default(0);
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
        Schema::dropIfExists('account_transactions');
    }
}
