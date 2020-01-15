<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeMovementDescriptionInMovementTransactionTable extends Migration
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
            $table->renameColumn('movimientos_descripcion_id', 'movimientos_descripcion');
        });
        DB::statement('ALTER TABLE movimientos_transactions MODIFY movimientos_descripcion varchar(255);');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('ALTER TABLE movimientos_transactions MODIFY movimientos_descripcion int(11);');
        Schema::table('movimientos_transactions', function (Blueprint $table)
        {
            $table->renameColumn('movimientos_descripcion', 'movimientos_descripcion_id');
        });
    }

}
