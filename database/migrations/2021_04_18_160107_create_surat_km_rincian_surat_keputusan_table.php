<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSuratKmRincianSuratKeputusanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('surat_km_rincian_surat_keputusan', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('induk_id');
            $table->text('tentang');
            $table->text('menimbang');
            $table->text('mengingat');
            $table->text('menetapkan');
            $table->string('tembusan');

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
        Schema::dropIfExists('surat_km_rincian_surat_keputusan');
    }
}
