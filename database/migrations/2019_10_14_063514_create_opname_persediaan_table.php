<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOpnamePersediaanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('opname_persediaan', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('id_barang');
            $table->string('nama_barang');
            $table->integer('bulan');
            $table->integer('saldo_awal');
            $table->decimal('harga_awal', 13, 2);
            $table->integer('saldo_tambah');
            $table->decimal('harga_tambah', 13, 2);
            
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
        Schema::dropIfExists('opname_persediaan');
    }
}
