<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserDashboardTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_dashboard_widgets', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('dashboard_widget_id')->unsigned();
            $table->string('slot', 25);
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->foreign('dashboard_widget_id')
                ->references('id')
                ->on('dashboard_widgets')
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
        Schema::table('user_dashboard_widgets', function (Blueprint $table) {
            $table->dropForeign('user_dashboard_widgets_user_id_foreign');
            $table->dropForeign('user_dashboard_widgets_dashboard_widget_id_foreign');
        });
        Schema::drop('user_dashboard_widgets');
    }
}
