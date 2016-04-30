<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOfferCategoryTable extends Migration
{
    const TABLE = 'nh_offer_category';
    
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
            $table->integer('category_id');
            $table->unique(['offer_id', 'category_id']);

            $table->timestamps();

            $table->foreign('offer_id')
                ->references('id')
                ->on('nh_offer')
                ->onDelete('cascade');

            $table->foreign('category_id')
                ->references('id')
                ->on('nh_category')
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
        //
    }
}
