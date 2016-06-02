<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddImageiconToFilters extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
     {
         Schema::table('filters', function (Blueprint $table) {
             $table->integer('image_id')->nullable();
             $table->dropColumn('icon');
         });
     }

     /**
      * Reverse the migrations.
      *
      * @return void
      */
     public function down()
     {
         Schema::table('filters', function (Blueprint $table) {
             $table->dropColumn('image_id');
             $table->string('icon', 20)->nullable();
         });
     }
}
