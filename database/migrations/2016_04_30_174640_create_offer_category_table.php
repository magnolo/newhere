<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOfferCategoryTable extends Migration
{
    const TABLE = 'offer_categories';

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
            $table->integer('category_id');
            $table->unique(['offer_id', 'category_id']);

            $table->timestamps();

            $table->foreign('offer_id', sprintf('%1$s_offer_id_foreign', self::TABLE))
                ->references('id')
                ->on('offers')
                ->onDelete('cascade');

            $table->foreign('category_id', sprintf('%1$s_category_id_foreign', self::TABLE))
                ->references('id')
                ->on('categories')
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
            $table->dropForeign(sprintf('%1$s_category_id_foreign', self::TABLE));
        });
        Schema::drop(self::TABLE);
    }
}
