<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserOtherAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_other_accounts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('account_id');
            $table->enum('type_of_recipient',['personal','company']);
            $table->enum('destination_type',['same','international']);
            $table->integer('instrument_id');
            $table->string('first_name');
            $table->string('telephone');
            $table->string('currency');
            $table->string('address');
            $table->integer('country');
            $table->string('state');
            $table->string('city');
            $table->integer('dest_bank_country');
            $table->string('dest_account_number');
            $table->string('dest_swift');
            $table->string('dest_bank_name');
            $table->string('dest_bank_address');

            $table->tinyinteger('intermediary_banking');
            $table->integer('intermediary_bank_country');
            $table->string('intermediary_bank_account');
            $table->string('intermediary_swift');
            $table->string('intermediary_bank_name');
            $table->string('intermediary_bank_address');
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
        Schema::dropIfExists('user_other_accounts');
    }
}
