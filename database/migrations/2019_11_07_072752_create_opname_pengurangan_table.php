<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOpnamePenguranganTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('opname_pengurangan', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('id_barang');
            $table->integer('bulan');
            $table->integer('tahun');
            $table->integer('jumlah_kurang');
            $table->decimal('harga_kurang', 13, 2);  
            $table->integer('unit_kerja');  
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
        Schema::dropIfExists('opname_pengurangan');
    }
}
