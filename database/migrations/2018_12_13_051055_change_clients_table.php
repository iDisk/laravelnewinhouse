<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->dropColumn(['broker_id', 'type_of_acc', 'acc_number','credit_capability','opening_amount','date_of_transfer','sender_bank','fund_country','clearing_house','custodian_bank','credit_liine_facility','sales','manager','customer_care','analyst','other1','other2','other3','other4','other_documents1','other_documents2','other_documents3','other_compliance_requirement']);
        });

        Schema::table('clients', function (Blueprint $table) {
            $table->string('county')->nullable()->change();
            $table->string('address')->nullable()->change();
            $table->integer('country')->nullable()->change();
            $table->integer('state')->nullable()->change();
            $table->integer('city')->nullable()->change();
            $table->string('zip_code')->nullable()->change();
            $table->integer('client_type')->default(0)->comment('1 = Primary')->after('email2');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('clients', function (Blueprint $table) {
            //
        });
    }
}
