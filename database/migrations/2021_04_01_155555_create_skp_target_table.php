<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSkpTargetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('skp_target', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('id_induk');
            $table->string('user_id');
            $table->string('uraian');
            $table->string('satuan');
            $table->float('target_kuantitas');
            $table->integer('kode_point_kredit')->nullable();
            $table->float('angka_kredit')->nullable();
            $table->float('target_kualitas');
            $table->integer('waktu');
            $table->string('satuan_waktu');
            $table->decimal('biaya',12,2)->nullable();

            $table->integer('jenis');
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
        Schema::dropIfExists('skp_target');
    }
}
