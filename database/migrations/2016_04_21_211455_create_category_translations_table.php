<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoryTranslationsTable extends Migration
{
    const TABLE = 'nh_category_translation';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(self::TABLE, function (Blueprint $table) {
            $table->increments('id');
            $table->integer('category_id');
            $table->integer('language_id');
            $table->string('title');
            $table->text('description');
            $table->integer('version')->default(1);
            $table->timestamps();

            $table->unique(['category_id', 'language_id']);

            $table->foreign('category_id', sprintf('%1$s_category_id_foreign', self::TABLE))
                ->references('id')
                ->on('nh_category')
                ->onDelete('cascade');

            $table->foreign('language_id', sprintf('%1$s_language_id_foreign', self::TABLE))
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
        Schema::table(self::TABLE, function (Blueprint $table) {
            $table->dropForeign(sprintf('%1$s_category_id_foreign', self::TABLE));
            $table->dropForeign(sprintf('%1$s_language_id_foreign', self::TABLE));
        });
        Schema::drop(self::TABLE);
    }
}
