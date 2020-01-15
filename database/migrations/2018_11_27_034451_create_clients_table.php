<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('broker_id');
            $table->enum('type_of_acc',['individual','joint','business_account']);
            $table->string('acc_number');
            $table->string('first_name',50);
            $table->string('middle_name',50);
            $table->string('surname1');
            $table->string('surname2');
            $table->integer('national_identity_doc_id');
            $table->string('national_identity_number',50);
            $table->date('dob');
            $table->string('gender',15);
            $table->string('birth_place',191);
            $table->integer('birth_country');
            $table->string('nationality',50);
            $table->string('address');
            $table->integer('country');
            $table->integer('state');
            $table->integer('city');
            $table->string('zip_code',50);
            $table->string('county',50);
            $table->string('company',50)->nullable();
            $table->string('industry_type',50)->nullable();
            $table->string('occupation',50)->nullable();
            $table->string('marrital_status',50)->nullable();
            $table->string('spouse_name',50)->nullable();
            $table->string('telephone1',50);
            $table->string('telephone2',50)->nullable();
            $table->string('telephone3',50)->nullable();
            $table->string('email1',50);
            $table->string('email2',50)->nullable();
            $table->integer('credit_capability')->default(3);
            $table->decimal('opening_amount', 8, 2)->default(0);
            $table->date('date_of_transfer');
            $table->string('sender_bank',50);
            $table->integer('fund_country');
            $table->string('clearing_house');
            $table->string('custodian_bank');
            $table->enum('credit_liine_facility',['Yes','No']);
            $table->string('sales',50);
            $table->string('manager',50);
            $table->string('customer_care',50);
            $table->string('analyst',50);
            $table->string('other1',50)->nullable();
            $table->string('other2',50)->nullable();
            $table->string('other3',50)->nullable();
            $table->string('other4',50)->nullable();
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
        Schema::dropIfExists('clients');
    }
}
