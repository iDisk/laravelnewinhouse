<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserSecuritiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_securities', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('security_image_id')->nullable();
            $table->integer('security_question1_id')->nullable();
            $table->string('answer1',191)->nullable();
            $table->integer('security_question2_id')->nullable();
            $table->string('answer2',191)->nullable();
            $table->integer('security_question3_id')->nullable();
            $table->string('answer3',191)->nullable();
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
        Schema::dropIfExists('user_securities');
    }
}
