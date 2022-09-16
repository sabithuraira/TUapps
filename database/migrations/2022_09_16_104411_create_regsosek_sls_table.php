<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRegsosekSlsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('regsosek_sls', function (Blueprint $table) {
            $table->increments('id');

            $table->string("kode_prov", 2);
            $table->string("kode_kab", 2);
            $table->string("kode_kec", 2);
            $table->string("kode_desa", 2);

            $table->string("id_sls", 4);
            $table->string("id_sub_sls", 4);
            $table->string("nama_sls");
            $table->integer("sls_op");
            $table->integer("jenis_sls");
            $table->integer("j_keluarga_sls");

            $table->integer("j_keluarga_pcl")->default(0);
            $table->integer("j_keluarga_pml")->default(0);
            $table->integer("j_keluarga_koseka")->default(0);

            $table->integer("status_selesai_pcl")->default(0);

            $table->integer("j_tidak_miskin")->default(0);
            $table->integer("j_miskin")->default(0);
            $table->integer("j_sangat_miskin")->default(0);
            $table->integer("j_nr")->default(0);
            
            $table->string("kode_pcl")->nullable();
            $table->string("kode_pml")->nullable();
            $table->string("kode_koseka")->nullable();
            
            $table->integer("status_sls")->default(0);
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
        Schema::dropIfExists('regsosek_sls');
    }
}
