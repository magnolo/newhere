<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNgoUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ngo_users', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('ngo_id')->unsigned();
            $table->integer('user_id')->unsigned();

            $table->unique(['ngo_id', 'user_id']);

            $table->timestamps();


            $table->foreign('ngo_id')
              ->references('id')
              ->on('ngos')
              ->onDelete('cascade');

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
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
        Schema::drop('ngo_users');
    }
}
