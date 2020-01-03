<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOpnamePenambahan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('opname_penambahan', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('id_barang');
            $table->integer('bulan');
            $table->integer('tahun');
            $table->integer('jumlah_tambah');
            $table->decimal('harga_tambah', 13, 2);  
            $table->string('nama_penyedia');  
            $table->date('tanggal');    
            $table->string('created_by');
            $table->string('updated_by');

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
        Schema::dropIfExists('opname_penambahan');
    }
}
