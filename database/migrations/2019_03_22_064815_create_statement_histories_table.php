<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStatementHistoriesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('statement_histories', function (Blueprint $table)
        {
            $table->increments('id');
            $table->enum('type', ['trade', 'movement'])->default('trade');
            $table->integer('account_id')->unsigned();
            $table->text('file_path');
            $table->date('from_period');
            $table->date('upto_period');
            $table->enum('generated_by', ['system', 'admin'])->default('admin');
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
        Schema::dropIfExists('statement_histories');
    }

}
