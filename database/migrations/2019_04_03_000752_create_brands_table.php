<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBrandsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('brokers', function (Blueprint $table)
        {
            $table->longText('description')->nullable()->after('broker');
            $table->tinyInteger('active')->default('1')->after('code');
        });

        Schema::table('settings', function (Blueprint $table)
        {
            $table->integer('broker_id')->unsigned()->after('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('brokers', function (Blueprint $table)
        {
            $table->dropColumn('description');
            $table->dropColumn('active');
        });

        Schema::table('settings', function (Blueprint $table)
        {
            $table->dropColumn('broker_id');
        });
    }

}
