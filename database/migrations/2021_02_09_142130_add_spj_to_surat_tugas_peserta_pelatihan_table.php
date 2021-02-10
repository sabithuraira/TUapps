<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSpjToSuratTugasPesertaPelatihanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('surat_tugas_peserta_pelatihan', function (Blueprint $table) {
            $table->decimal('biaya_perjadin',9,2)->nullable();
            $table->decimal('biaya_fullboard',9,2)->nullable();
            $table->decimal('transport_pergi',9,2)->nullable();
            $table->decimal('transport_pulang',9,2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('surat_tugas_peserta_pelatihan', function (Blueprint $table) {
            //
        });
    }
}
