<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBuktiAgainToSiraRincianTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sira_rincian', function (Blueprint $table) {
            $table->string("path_spk")->nullable();
            $table->string("path_bast")->nullable();
            $table->string("path_rekap_belanja")->nullable();
            $table->string("path_laporan")->nullable();
            $table->string("path_jadwal")->nullable();
            $table->string("path_drpp")->nullable();
            $table->string("path_invoice")->nullable();
            $table->string("path_resi_pengiriman")->nullable();
            $table->string("path_npwp_rekkor")->nullable();
            $table->string("path_tanda_terima")->nullable();
            $table->string("path_cv")->nullable();
            $table->string("path_bahan_paparan")->nullable();
            $table->string("path_ba_pembayaran")->nullable();
            $table->string("path_spd_visum")->nullable();
            $table->string("path_presensi_uang_makan")->nullable();
            $table->string("path_rincian_perjadin")->nullable();
            $table->string("path_bukti_transport")->nullable();
            $table->string("path_bukti_inap")->nullable();
            $table->string("path_lpd")->nullable();
            $table->string("path_rekap_perjadin")->nullable();
            $table->string("path_sp_kendaraan_dinas")->nullable();
            $table->string("path_daftar_rill")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sira_rincian', function (Blueprint $table) {
            //
        });
    }
}
