<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoryTranslationsTable extends Migration
{
    const TABLE = 'category_translations';

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
          $table->integer('category_id')->unsigned();
          $table->string('title');
          $table->text('description');
          $table->integer('version')->default(1);
          $table->string('locale')->index();
          $table->timestamps();

          $table->unique(['category_id','locale']);
          $table->foreign('category_id')
            ->references('id')
            ->on('categories')
            ->onDelete('cascade');
      });
      /*Schema::create(self::TABLE, function (Blueprint $table) {
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
                ->on('categories')
                ->onDelete('cascade');

            $table->foreign('language_id', sprintf('%1$s_language_id_foreign', self::TABLE))
                ->references('id')
                ->on('languages')
                ->onDelete('cascade');
        });*/
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
        });
        Schema::drop(self::TABLE);
    }
}
