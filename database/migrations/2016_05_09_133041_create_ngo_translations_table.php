<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNgoTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ngo_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('ngo_id');

            $table->integer('version')->default(1);

            $table->text('description');

            $table->string('locale')->index();
            $table->timestamps();

            $table->unique(['ngo_id', 'locale']);

            $table->foreign('ngo_id')
                ->references('id')
                ->on('ngos')
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
      Schema::table('ngo_translations', function (Blueprint $table) {
         $table->dropForeign('ngo_translations_ngo_id_foreign');
      });

        Schema::drop('ngo_translations');
    }
}
