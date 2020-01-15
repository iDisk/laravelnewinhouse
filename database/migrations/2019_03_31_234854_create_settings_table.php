<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table)
        {
            $table->increments('id');
            $table->string('company_statement_logo')->nullable();
            $table->string('contact_number')->nullable();
            $table->string('website_url')->nullable();
            $table->string('admin_email')->nullable();
            $table->string('admin_name')->nullable();
            $table->string('statement_legend')->nullable();
            $table->string('statement_legend_color')->nullable();
            $table->longText('disclaimer')->nullable();
            $table->tinyInteger('template_id')->default(1);
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
        Schema::dropIfExists('settings');
    }

}
