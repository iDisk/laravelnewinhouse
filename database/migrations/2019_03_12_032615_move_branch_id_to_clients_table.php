<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MoveBranchIdToClientsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('accounts', function (Blueprint $table)
        {
            $table->dropColumn('branch_id');
        });

        Schema::table('clients', function (Blueprint $table)
        {
            $table->integer('branch_id')->unsigned()->default(1)->after('client_type');
        });

        Schema::table('business_details', function (Blueprint $table)
        {
            $table->integer('branch_id')->unsigned()->default(1)->after('email2');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('clients', function (Blueprint $table)
        {
            $table->dropColumn('branch_id');
        });

        Schema::table('business_details', function (Blueprint $table)
        {
            $table->dropColumn('branch_id');
        });

        Schema::table('accounts', function (Blueprint $table)
        {
            $table->integer('branch_id')->unsigned()->default(1)->after('broker_id');
        });
    }

}
