<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOfferCountriesTable extends Migration
{
    const TABLE = 'offer_countries';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(self::TABLE, function(Blueprint $table)
        {
            $table->increments('id');

            $table->integer('offer_id');
            $table->integer('country_id');
            $table->unique(['offer_id', 'country_id']);

            $table->timestamps();

            $table->foreign('offer_id', sprintf('%1$s_offer_id_foreign', self::TABLE))
                ->references('id')
                ->on('offers')
                ->onDelete('cascade');

            $table->foreign('country_id', sprintf('%1$s_country_id_foreign', self::TABLE))
                ->references('id')
                ->on(\Config::get('countries.table_name'))
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(self::TABLE, function (Blueprint $table) {
            $table->dropForeign(sprintf('%1$s_offer_id_foreign', self::TABLE));
            $table->dropForeign(sprintf('%1$s_country_id_foreign', self::TABLE));
        });
        Schema::drop(self::TABLE);
    }
}
