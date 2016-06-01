<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilterTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('filter_translations', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('filter_id')->unsigned();

          $table->string('title');
          $table->text('description')->nullable();

          $table->bigInteger('version')->default(1);

          $table->string('locale')->index();
          $table->timestamps();

          $table->unique(['filter_id','locale']);
          $table->foreign('filter_id')
            ->references('id')
            ->on('filters')
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
        Schema::table('filter_translations', function (Blueprint $table) {
          $table->dropForeign('filter_translations_filter_id_foreign');
        });
        Schema::drop('filter_translations');
    }
}
