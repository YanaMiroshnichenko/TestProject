<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('price')->nullable();
            $table->integer('number_of_rooms')->nullable();
            $table->string('area')->nullable();
            $table->integer('number_of_floors')->nullable();
            $table->integer('floor')->nullable();
            $table->string('short_description')->nullable();
            $table->text('detailed_description')->nullable();
            $table->string('link')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('product');
    }
}
