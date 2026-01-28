<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDailyStandupTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('daily_standup', function (Blueprint $table) {
            $table->increments('id');
            $table->string('pegawai_nip');
            $table->integer('tim_id'); // Foreign key to master_tim table
            $table->date('tanggal');
            $table->text('isi');
            $table->text('keterangan')->nullable();
            $table->integer('created_by'); // Foreign key to users table
            $table->integer('updated_by'); // Foreign key to users table
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
        Schema::dropIfExists('daily_standup');
    }
}
