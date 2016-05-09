<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOfferTranslationsTable extends Migration
{
    const TABLE = 'offer_translations';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(self::TABLE, function (Blueprint $table) {
            $table->increments('id');
            $table->integer('offer_id');

            $table->integer('version')->default(1);

            $table->string('title');
            $table->text('description');
            $table->text('opening_hours')->nullable();

            $table->string('locale')->index();
            $table->timestamps();

            $table->unique(['offer_id', 'locale']);

            $table->foreign('offer_id', sprintf('%1$s_offer_id_foreign', self::TABLE))
                ->references('id')
                ->on('offers')
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
            $table->dropForeign(sprintf('%1$s_language_id_foreign', self::TABLE));
        });
        Schema::drop(self::TABLE);
    }
}
