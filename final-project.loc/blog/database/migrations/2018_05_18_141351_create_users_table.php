<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->text('password')->nullable();
        });
        DB::table('users')->insert([
            'name' => 'Yana',
            'email' => 'yyanam@yandex.ru',
            'password' => md5('12345678')
        ]);
        DB::table('users')->insert([
            'name' => 'Test',
            'email' => 'test@tes.t',
            'password' => md5('12345678')
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}
