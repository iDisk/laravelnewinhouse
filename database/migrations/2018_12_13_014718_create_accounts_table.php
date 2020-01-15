<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('broker_id');
            $table->string('account_number',191);
            $table->enum('account_type',['individual','joint','business']);
            $table->integer('credit_capability')->default(3);
            $table->decimal('opening_amount', 10, 2)->default(0);
            $table->date('date_of_transfer');
            $table->string('sender_bank',50);
            $table->integer('fund_country');
            $table->string('clearing_house');
            $table->string('custodian_bank');
            $table->enum('credit_line_facility',['Yes','No']);
            $table->integer('sales');
            $table->integer('manager');
            $table->integer('customer_care');
            $table->integer('analyst');
            $table->string('other1',50)->nullable();
            $table->string('other2',50)->nullable();
            $table->string('other3',50)->nullable();
            $table->string('other4',50)->nullable();
            $table->tinyInteger('copy_of_id')->default(0);
            $table->tinyInteger('utility_bill')->default(0);
            $table->tinyInteger('bank_statement')->default(0);
            $table->tinyInteger('bank_transfer_voucher')->default(0);
            $table->tinyInteger('application')->default(0);
            $table->tinyInteger('biometric_signature')->default(0);
            $table->tinyInteger('contract')->default(0);
            $table->tinyInteger('credit_line')->default(0);
            $table->string('other_documents1',50)->nullable();
            $table->string('other_documents2',50)->nullable();
            $table->string('other_documents3',50)->nullable();
            $table->string('other_compliance_requirement',50)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accounts');
    }
}
