<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDailyLimitsInAccountsTable extends Migration
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
            $table->decimal('transfer_internal_account', 10, 2)->default(0.00)->after('opt_notification');
            $table->decimal('transfer_third_party_account', 10, 2)->default(0.00)->after('transfer_internal_account');
            $table->decimal('transfer_international_account', 10, 2)->default(0.00)->after('transfer_third_party_account');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('accounts', function (Blueprint $table)
        {
            $table->dropColumn('transfer_internal_account');
            $table->dropColumn('transfer_third_party_account');
            $table->dropColumn('transfer_international_account');
        });
    }

}
