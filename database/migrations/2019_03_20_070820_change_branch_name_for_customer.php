<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeBranchNameForCustomer extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clients', function (Blueprint $table)
        {
            $table->string('branch_id')->nullable()->change();
        });

        Schema::table('business_details', function (Blueprint $table)
        {
            $table->string('branch_id')->nullable()->change();
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
            $table->integer('branch_id')->unsigned()->default(1)->change();
        });

        Schema::table('business_details', function (Blueprint $table)
        {
            $table->integer('branch_id')->unsigned()->default(1)->change();
        });
    }

}
