<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCommissionInConfigurationTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('settings', function (Blueprint $table)
        {
            $table->decimal('transfer_commission_percentage', 4, 2)->default(0)->after('contact_number');
            $table->decimal('transfer_commission_amount', 10, 2)->default(0)->after('transfer_commission_percentage');
            $table->decimal('processing_fees_percentage', 4, 2)->default(0)->after('transfer_commission_amount');
            $table->decimal('processing_fees_amount', 10, 2)->default(0)->after('processing_fees_percentage');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('settings', function (Blueprint $table)
        {
            $table->dropColumn('transfer_commission_percentage');
            $table->dropColumn('transfer_commission_amount');
            $table->dropColumn('processing_fees_percentage');
            $table->dropColumn('processing_fees_amount');
        });
    }

}
