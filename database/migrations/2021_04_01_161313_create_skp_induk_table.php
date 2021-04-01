<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSkpIndukTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('skp_induk', function (Blueprint $table) {
            $table->increments('id');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->string('user_id');
            $table->string("user_pangkat");
            $table->string("user_gol");
            $table->string("user_jabatan");
            $table->string("user_unit_kerja");
            
            $table->string('pimpinan_id');
            $table->string("pimpinan_pangkat");
            $table->string("pimpinan_gol");
            $table->string("pimpinan_jabatan");
            $table->string("pimpinan_unit_kerja");
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
        Schema::dropIfExists('skp_induk');
    }
}
