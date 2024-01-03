<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMasterTimTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_tim', function (Blueprint $table) {
            $table->increments('id');

            $table->string("nama_tim");
            $table->char("kode_prov",2);
            $table->char("kode_kab",2);
            $table->integer("tahun");
            $table->string("nama_ketua_tim")->nullable();
            $table->string("nik_ketua_tim")->nullabel;
            $table->integer("jumlah_anggota")->default(0);

            $table->integer("created_by");
            $table->integer("updated_by");
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
        Schema::dropIfExists('master_tim');
    }
}
