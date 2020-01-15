<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBusinessDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('business_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('account_id');
            $table->string('registered_name',191);
            $table->string('business_type',191);
            $table->string('authorised_signatories1',191);
            $table->string('authorised_signatories2',191);
            $table->string('registration_number',191);
            $table->date('incorporation_date')->nullable();
            $table->string('incorporation_place');
            $table->string('address');
            $table->integer('country');
            $table->integer('state');
            $table->integer('city');
            $table->string('county',191);
            $table->string('zip_code',50);
            $table->string('industry_type',191)->nullable();
            $table->string('employees',191)->nullable();
            $table->string('webiste',191)->nullable();
            $table->string('telephone1',20);
            $table->string('telephone2',20)->nullable();
            $table->string('telephone3',20)->nullable();
            $table->string('email1',50);
            $table->string('email2',50)->nullable();
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
        Schema::dropIfExists('business_details');
    }
}
