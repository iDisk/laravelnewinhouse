<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIsOpeningInTradeInvestmentTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('trade_investments', function (Blueprint $table)
        {
            $table->tinyInteger('is_opening')->default(0)->after('exposicion');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('trade_investments', function (Blueprint $table)
        {
            $table->removeColumn('is_opening');
        });
    }

}
