<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOfferTranslationsTable extends Migration
{
    const TABLE = 'nh_offer_translation';

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
            $table->integer('language_id');

            $table->integer('version')->default(1);

            $table->string('title');
            $table->text('description');
            $table->text('opening_hours')->nullable();

            $table->timestamps();

            $table->unique(['offer_id', 'language_id']);

            $table->foreign('offer_id')
                ->references('id')
                ->on('nh_offer')
                ->onDelete('cascade');

            $table->foreign('language_id')
                ->references('id')
                ->on('nh_language')
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
        Schema::drop(self::TABLE);
    }
}
