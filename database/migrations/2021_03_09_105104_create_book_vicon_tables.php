<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookViconTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vicon', function (Blueprint $table) {
            $table->increments('id');
            $table->date('tanggal');
            $table->string('keperluan');
            // $table->integer('unitkerja');
            $table->string('ketua')->nullable();
            $table->datetime('jamawalguna');
            $table->datetime('jamakhirguna');
            $table->integer('status'); 

            $table->integer('created_by');
            $table->integer('updated_by');
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
        Schema::dropIfExists('vicon');
    }
}
