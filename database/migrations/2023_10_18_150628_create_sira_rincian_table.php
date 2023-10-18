<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSiraRincianTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sira_rincian', function (Blueprint $table) {
            $table->increments('id');

            $table->string("kode_mak");
            $table->string("kode_akun");

            $table->string("kode_fungsi");
            $table->string("path_kak")->nullable();
            $table->string("path_form_permintaan")->nullable();
            $table->string("path_notdin")->nullable();
            $table->string("path_undangan")->nullable();
            $table->string("path_bukti_pembayaran")->nullable();
            $table->string("path_kuitansi")->nullable();
            $table->string("path_notulen")->nullable();
            $table->string("path_daftar_hadir")->nullable();
            $table->string("path_sk")->nullable();
            $table->string("path_st")->nullable();

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
        Schema::dropIfExists('sira_rincian');
    }
}
