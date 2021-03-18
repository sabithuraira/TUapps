<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBps1674UserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bps1674_user', function (Blueprint $table) {
            $table->increments('id');

            $table->string('username');
            $table->string('email');
            $table->string('nama');
            $table->string('password');
            $table->string('organisasi');
            $table->datetime('last_login')->nullable();
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
        Schema::dropIfExists('bps1674_user');
    }
}
