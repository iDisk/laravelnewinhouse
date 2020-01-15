<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSpanishDocumentsInBrokerTable extends Migration
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
        //Rename field first
        Schema::table('settings', function (Blueprint $table)
        {
            $table->renameColumn('disclaimer', 'disclaimer_es');
            $table->renameColumn('footer_privacy_policy', 'footer_privacy_policy_es');
            $table->renameColumn('footer_tnc', 'footer_tnc_es');
            $table->renameColumn('footer_privacy_notice', 'footer_privacy_notice_es');
            $table->renameColumn('international_transfer_disclaimer', 'international_transfer_disclaimer_es');
            $table->renameColumn('financing_request_disclaimer', 'financing_request_disclaimer_es');
            $table->renameColumn('financing_request_tnc', 'financing_request_tnc_es');
            $table->renameColumn('expand_financing_disclaimer', 'expand_financing_disclaimer_es');
            $table->renameColumn('expand_financing_tnc', 'expand_financing_tnc_es');
            $table->renameColumn('refinancing_disclaimer', 'refinancing_disclaimer_es');
            $table->renameColumn('access_control_tnc', 'access_control_tnc_es');
            $table->renameColumn('accounts_administration_tnc', 'accounts_administration_tnc_es');
            $table->renameColumn('adjust_permission_tnc', 'adjust_permission_tnc_es');
            $table->renameColumn('send_documentation_disclaimer', 'send_documentation_disclaimer_es');
            $table->renameColumn('account_registration_disclaimer', 'account_registration_disclaimer_es');
        });

        //Add English fields
        Schema::table('settings', function (Blueprint $table)
        {
            $table->longText('disclaimer_en')->nullable()->after('disclaimer_es');
            $table->longText('footer_privacy_policy_en')->nullable()->after('footer_privacy_policy_es');
            $table->longText('footer_tnc_en')->nullable()->after('footer_tnc_es');
            $table->longText('footer_privacy_notice_en')->nullable()->after('footer_privacy_notice_es');
            $table->longText('international_transfer_disclaimer_en')->nullable()->after('international_transfer_disclaimer_es');
            $table->longText('financing_request_disclaimer_en')->nullable()->after('financing_request_disclaimer_es');
            $table->longText('financing_request_tnc_en')->nullable()->after('financing_request_tnc_es');
            $table->longText('expand_financing_disclaimer_en')->nullable()->after('expand_financing_disclaimer_es');
            $table->longText('expand_financing_tnc_en')->nullable()->after('expand_financing_tnc_es');
            $table->longText('refinancing_disclaimer_en')->nullable()->after('refinancing_disclaimer_es');
            $table->longText('access_control_tnc_en')->nullable()->after('access_control_tnc_es');
            $table->longText('accounts_administration_tnc_en')->nullable()->after('accounts_administration_tnc_es');
            $table->longText('adjust_permission_tnc_en')->nullable()->after('adjust_permission_tnc_es');
            $table->longText('send_documentation_disclaimer_en')->nullable()->after('send_documentation_disclaimer_es');
            $table->longText('account_registration_disclaimer_en')->nullable()->after('account_registration_disclaimer_es');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //Remove English fields
        Schema::table('settings', function (Blueprint $table)
        {
            $table->dropColumn('disclaimer_en');
            $table->dropColumn('footer_privacy_policy_en');
            $table->dropColumn('footer_tnc_en');
            $table->dropColumn('footer_privacy_notice_en');
            $table->dropColumn('international_transfer_disclaimer_en');
            $table->dropColumn('financing_request_disclaimer_en');
            $table->dropColumn('financing_request_tnc_en');
            $table->dropColumn('expand_financing_disclaimer_en');
            $table->dropColumn('expand_financing_tnc_en');
            $table->dropColumn('refinancing_disclaimer_en');
            $table->dropColumn('access_control_tnc_en');
            $table->dropColumn('accounts_administration_tnc_en');
            $table->dropColumn('adjust_permission_tnc_en');
            $table->dropColumn('send_documentation_disclaimer_en');
            $table->dropColumn('account_registration_disclaimer_en');
        });

        //rename (revert) fields
        Schema::table('settings', function (Blueprint $table)
        {
            $table->removeColumn('disclaimer_es', 'disclaimer');
            $table->removeColumn('footer_privacy_policy_es', 'footer_privacy_policy');
            $table->removeColumn('footer_tnc_es', 'footer_tnc');
            $table->removeColumn('footer_privacy_notice_es', 'footer_privacy_notice');
            $table->removeColumn('international_transfer_disclaimer_es', 'international_transfer_disclaimer');
            $table->removeColumn('financing_request_disclaimer_es', 'financing_request_disclaimer');
            $table->removeColumn('financing_request_tnc_es', 'financing_request_tnc');
            $table->removeColumn('expand_financing_disclaimer_es', 'expand_financing_disclaimer');
            $table->removeColumn('expand_financing_tnc_es', 'expand_financing_tnc');
            $table->removeColumn('refinancing_disclaimer_es', 'refinancing_disclaimer');
            $table->removeColumn('access_control_tnc_es', 'access_control_tnc');
            $table->removeColumn('accounts_administration_tnc_es', 'accounts_administration_tnc');
            $table->removeColumn('adjust_permission_tnc_es', 'adjust_permission_tnc');
            $table->removeColumn('send_documentation_disclaimer_es', 'send_documentation_disclaimer');
            $table->removeColumn('account_registration_disclaimer_es', 'account_registration_disclaimer');
        });
    }

}
