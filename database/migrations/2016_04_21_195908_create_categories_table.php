<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTable extends Migration
{
    const TABLE = 'nh_category';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(self::TABLE, function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent')->nullable();

            $table->string('icon', 20);
            $table->boolean('enabled')->default(true);
            $table->timestamps();

            $table->foreign('parent', sprintf('%1$s_parent_foreign', self::TABLE))
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
            $table->dropForeign(sprintf('%1$s_parent_foreign', self::TABLE));
        });
        Schema::drop(self::TABLE);
    }
}