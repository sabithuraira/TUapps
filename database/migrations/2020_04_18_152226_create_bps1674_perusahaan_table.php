<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBps1674PerusahaanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bps1674_perusahaan', function (Blueprint $table) {
            $table->increments('id');

            $table->string('nama');
            $table->text('deskripsi');
            $table->text('alamat');
            $table->char('kdprop', 2)->nullable();
            $table->char('kdkab', 2)->nullable();
            $table->char('kdkec', 3)->nullable();
            $table->string('kategori');
            
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
        Schema::dropIfExists('bps1674_perusahaan');
    }
}
