<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFiltersTable extends Migration
{
    const TABLE = 'filters';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(self::TABLE, function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent_id')->nullable();
            $table->string('slug')->nullable();
            $table->string('icon')->nullable();
            $table->string('type')->nullable();
            $table->boolean('enabled')->default(true);
            $table->timestamps();

            $table->foreign('parent_id')
                ->references('id')
                ->on(self::TABLE)
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
          $table->dropForeign(sprintf('%1$s_parent_id_foreign', self::TABLE));
      });
        Schema::drop(self::TABLE);
    }
}
