<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnggotaTimTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('anggota_tim', function (Blueprint $table) {
            $table->increments('id');

            $table->integer("id_tim");
            $table->string("nama_anggota");
            $table->string("nik_anggota");
            $table->integer("status_keanggotaan");
            $table->integer("is_active");

            $table->integer("created_by");
            $table->integer("updated_by");

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
        Schema::dropIfExists('anggota_tim');
    }
}
