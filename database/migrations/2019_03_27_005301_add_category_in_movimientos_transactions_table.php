<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCategoryInMovimientosTransactionsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('movimientos_transactions', function (Blueprint $table)
        {
            $table->tinyInteger('operation_category')->default(0)->after('movimientos_tipo_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('movimientos_transactions', function (Blueprint $table)
        {
            $table->dropColumn('operation_category');
        });
    }

}
