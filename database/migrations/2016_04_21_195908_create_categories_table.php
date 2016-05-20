<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTable extends Migration
{
    const TABLE = 'categories';

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
            $table->string('icon', 20);
            $table->boolean('enabled')->default(true);
            $table->integer('sortindex')->default(0);
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
