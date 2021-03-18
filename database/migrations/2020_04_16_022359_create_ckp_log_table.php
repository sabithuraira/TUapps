<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCkpLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ckp_log_bulanan', function (Blueprint $table) {
            $table->increments('id');

            $table->string('user_id');
            $table->integer('month');
            $table->integer('year');

            $table->float('target_kuantitas',8,2);
            $table->float('realisasi_kuantitas',8,2)->nullable();
            $table->float('kualitas',8,2)->nullable();
            $table->float('kecepatan',8,2)->nullable();
            $table->float('ketepatan',8,2)->nullable();
            $table->float('ketuntasan',8,2)->nullable();
            
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
        Schema::dropIfExists('ckp_log');
    }
}
