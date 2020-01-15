<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCategoryInMovementTypeTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('movimientos_tipos', function (Blueprint $table)
        {
            $table->integer('movimientos_tipo_category_id')->unsigned()->after('type_es');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('movimientos_tipos', function (Blueprint $table)
        {
            $table->dropColumn('movimientos_tipo_category_id');
        });
    }

}
