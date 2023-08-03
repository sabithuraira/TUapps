<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePesSt2023Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pes_st2023', function (Blueprint $table) {
            $table->increments('id');

            $table->string("kode_prov", 2);
            $table->string("kode_kab", 2);
            $table->string("kode_kec", 3);
            $table->string("kode_desa", 3);

            $table->string("id_sls", 4);
            $table->string("id_sub_sls", 4);
            $table->string("nama_sls");

            $table->integer("sls_op");
            
            $table->integer("jenis_sls");
            
            $table->integer("jml_ruta_tani")->default(0);
            $table->integer("jml_art_tani")->default(0);

            $table->integer("jml_ruta_pes")->default(0);
            $table->integer("jml_art_pes")->default(0);;
            $table->integer("status_selesai")->default(0);

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
        Schema::dropIfExists('pes_st2023');
    }
}
