<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCurhatAnonTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('curhat_anon', function (Blueprint $table) {
            $table->increments('id');
            $table->text('content');
            $table->tinyInteger('status_verifikasi')->default(1); // 1: Belum Verifikasi, 2: Disetujui, 3: Tidak Disetujui

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
        Schema::dropIfExists('curhat_anon');
    }
}

