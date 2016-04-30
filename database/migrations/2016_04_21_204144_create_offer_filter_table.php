<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOfferFilterTable extends Migration
{
    const TABLE = 'nh_offer_filter';

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
            $table->integer('filter_id');
            $table->unique(['offer_id', 'filter_id']);

            $table->timestamps();

            $table->foreign('offer_id')
                ->references('id')
                ->on('nh_offer')
                ->onDelete('cascade');

            $table->foreign('filter_id')
                ->references('id')
                ->on('nh_filter')
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
