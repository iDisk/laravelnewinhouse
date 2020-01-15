<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateBrokersTablePwm95 extends Migration
{

    public function __construct()
    {
        DB::getDoctrineSchemaManager()->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('settings', function (Blueprint $table)
        {
            $table->renameColumn('unsubscribe_tnc', 'adjust_permission_tnc');
            $table->longText('send_documentation_disclaimer')->after('unsubscribe_tnc');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('settings', function (Blueprint $table)
        {
            $table->renameColumn('adjust_permission_tnc', 'unsubscribe_tnc');
            $table->dropColumn('send_documentation_disclaimer');
        });
    }

}
