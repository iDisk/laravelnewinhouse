<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePromotionsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promotions', function (Blueprint $table)
        {
            $table->increments('id');
            $table->integer('broker_id')->unsigned();
            $table->string('promo_title');
            $table->text('short_description');
            $table->longText('long_description');
            $table->tinyInteger('estatus')->default(1);
            $table->timestamps();
            $table->foreign('broker_id')->references('id')->on('brokers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('promotions');
    }

}
