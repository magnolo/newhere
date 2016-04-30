<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNgosTable extends Migration
{
    const TABLE = 'nh_ngo';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(self::TABLE, function (Blueprint $table) {
            $table->increments('id');
            $table->string('organisation');
            $table->string('street')->nullable();
            $table->string('zip')->nullable();
            $table->string('city')->nullable();
            $table->string('phone');
            $table->string('email');
            $table->string('website');

            /**
             * @todo needs to be translated?!
             */
            $table->text('description');

            $table->text('contact');
            $table->text('contact_email');
            $table->text('contact_phone');

            $table->string('username')->unique();
            $table->string('password', 60);
            
            $table->timestamps();
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
