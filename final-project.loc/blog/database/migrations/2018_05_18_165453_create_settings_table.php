<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->nullable();
            $table->integer('price_from')->nullable();
            $table->integer('price_to')->nullable();
            $table->integer('number_of_rooms_from')->nullable();
            $table->integer('number_of_rooms_to')->nullable();
            $table->integer('floor_from')->nullable();
            $table->integer('floor_to')->nullable();
            $table->integer('email_notifications')->nullable();
            $table->integer('slack_notifications')->nullable();
            $table->string('channel_name')->nullable();
            $table->text('slack_link')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('settings');
    }
}
