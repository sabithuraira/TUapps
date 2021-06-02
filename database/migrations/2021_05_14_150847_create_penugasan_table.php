<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePenugasanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penugasan', function (Blueprint $table) {
            $table->increments('id');

            $table->text("isi");
            $table->text("keterangan")->nullable();
            $table->date("tanggal_mulai");
            $table->date("tanggal_selesai");
            $table->string('satuan');
            $table->integer('jenis_periode');
            $table->char('unit_kerja', 4);
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
        Schema::dropIfExists('penugasan');
    }
}
