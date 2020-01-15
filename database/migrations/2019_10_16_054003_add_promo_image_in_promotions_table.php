<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPromoImageInPromotionsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('promotions', function (Blueprint $table)
        {
            $table->string('promo_image')->after('long_description');
            $table->string('promo_image_thumb')->after('promo_image');
            $table->renameColumn('promo_title', 'promo_title_en');
            $table->renameColumn('short_description', 'short_description_en');
            $table->renameColumn('long_description', 'long_description_en');
        });

        Schema::table('promotions', function (Blueprint $table)
        {
            $table->string('promo_title_es')->after('promo_title_en');
            $table->text('short_description_es')->after('short_description_en');
            $table->longText('long_description_es')->after('long_description_en');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('promotions', function (Blueprint $table)
        {
            $table->dropColumn('promo_image');
            $table->dropColumn('promo_image_thumb');
            $table->renameColumn('promo_title_en', 'promo_title');
            $table->renameColumn('short_description_en', 'short_description');
            $table->renameColumn('long_description_en', 'long_description');
            $table->dropColumn('promo_title_es');
            $table->dropColumn('short_description_es');
            $table->dropColumn('long_description_es');
        });
    }

}
