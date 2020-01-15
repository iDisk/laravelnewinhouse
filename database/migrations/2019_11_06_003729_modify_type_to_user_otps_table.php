<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyTypeToUserOtpsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_otps', function (Blueprint $table) {
            //$table->enum('type',['change_password','registration','client_request'])->change();
            DB::statement("ALTER TABLE `user_otps` CHANGE `type` `type` ENUM('change_password','registration','client_request') NOT NULL;");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_otps', function (Blueprint $table) {
            DB::statement("ALTER TABLE `user_otps` CHANGE `type` `type` ENUM('change_password','registration') NOT NULL;");
        });
    }
}
