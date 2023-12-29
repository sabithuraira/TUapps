<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIkiMasterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('iki_master', function (Blueprint $table) {
            $table->id();
            $table->string('ik');
            $table->integer('id_user');
            $table->string('satuan');
            $table->string('target');
            $table->string('tahun');
            $table->string('bulan');
            $table->string('referensi_sumber')->nullable();
            $table->string('referensi_jenis');
            $table->integer('created_by');
            $table->integer('updated_by');
            $table->timestamps();
        });
        Schema::create('iki_bukti', function (Blueprint $table) {
            $table->id();
            $table->integer('id_iki');
            $table->integer('id_user');
            $table->string('jenis_bukti_dukung');
            $table->string('link_bukti_dukung')->nullable();
            $table->string('deadline');
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
        Schema::dropIfExists('iki_master');
        Schema::dropIfExists('iki_bukti');
    }
}
