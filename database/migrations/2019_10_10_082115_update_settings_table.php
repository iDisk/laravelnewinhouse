<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateSettingsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('brokers', function (Blueprint $table)
        {
            $table->string('broker_url')->after('code');
        });

        Schema::table('settings', function (Blueprint $table)
        {            
            $table->enum('menu_orientation', ['vertical', 'horizontal'])->default('vertical')->after('template_id');
            $table->string('brand_color_primary', 30)->nullable()->after('menu_orientation');
            $table->string('brand_color_seconday', 30)->nullable()->after('brand_color_primary');
            $table->string('font_color_primary', 30)->nullable()->after('brand_color_seconday');
            $table->string('font_color_secondary', 30)->nullable()->after('font_color_primary');

            $table->longText('footer_privacy_policy')->nullable()->after('font_color_secondary');
            $table->longText('footer_tnc')->nullable()->after('footer_privacy_policy');
            $table->longText('footer_privacy_notice')->nullable()->after('footer_tnc');
            
            $table->longText('international_transfer_disclaimer')->nullable()->after('footer_privacy_notice');
            $table->longText('financing_request_disclaimer')->nullable()->after('international_transfer_disclaimer');
            $table->longText('financing_request_tnc')->nullable()->after('financing_request_disclaimer');
            $table->longText('expand_financing_disclaimer')->nullable()->after('financing_request_tnc');
            $table->longText('expand_financing_tnc')->nullable()->after('expand_financing_disclaimer');
            $table->longText('refinancing_disclaimer')->nullable()->after('expand_financing_tnc');
            $table->longText('access_control_tnc')->nullable()->after('refinancing_disclaimer');
            $table->longText('accounts_administration_tnc')->nullable()->after('access_control_tnc');
            $table->longText('unsubscribe_tnc')->nullable()->after('accounts_administration_tnc');
            $table->longText('account_registration_disclaimer')->nullable()->after('unsubscribe_tnc');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('brokers', function (Blueprint $table)
        {
            $table->dropColumn('broker_url');
        });

        Schema::table('settings', function (Blueprint $table)
        {            
            $table->dropColumn('menu_orientation');
            $table->dropColumn('brand_color_primary');
            $table->dropColumn('brand_color_seconday');
            $table->dropColumn('font_color_primary');
            $table->dropColumn('font_color_secondary');
            $table->dropColumn('footer_privacy_policy');
            $table->dropColumn('footer_tnc');
            $table->dropColumn('footer_privacy_notice');
            $table->dropColumn('international_transfer_disclaimer');
            $table->dropColumn('financing_request_disclaimer');
            $table->dropColumn('financing_request_tnc');
            $table->dropColumn('expand_financing_disclaimer');
            $table->dropColumn('expand_financing_tnc');
            $table->dropColumn('refinancing_disclaimer');
            $table->dropColumn('access_control_tnc');
            $table->dropColumn('accounts_administration_tnc');
            $table->dropColumn('unsubscribe_tnc');
            $table->dropColumn('account_registration_disclaimer');
        });
    }

}
