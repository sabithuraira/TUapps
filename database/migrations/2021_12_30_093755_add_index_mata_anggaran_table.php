<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIndexMataAnggaranTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
        Schema::table('pok_program', function (Blueprint $table) {
            $table->index(['kode']);
        });
        
        Schema::table('pok_aktivitas', function (Blueprint $table) {
            $table->index(['id_program']);
            $table->index(['kode']);
        });
        
        Schema::table('pok_kro', function (Blueprint $table) {
            $table->index(['id_program']);
            $table->index(['id_aktivitas']);
            $table->index(['kode']);
        });
        
        Schema::table('pok_ro', function (Blueprint $table) {
            $table->index(['id_program']);
            $table->index(['id_aktivitas']);
            $table->index(['id_kro']);
            $table->index(['kode']);
        });
        
        Schema::table('pok_komponen', function (Blueprint $table) {
            $table->index(['id_program']);
            $table->index(['id_aktivitas']);
            $table->index(['id_kro']);
            $table->index(['id_ro']);
            $table->index(['kode']);
        });
        
        Schema::table('pok_sub_komponen', function (Blueprint $table) {
            $table->index(['id_program']);
            $table->index(['id_aktivitas']);
            $table->index(['id_kro']);
            $table->index(['id_ro']);
            $table->index(['id_komponen']);
            $table->index([ 'kode']);
        });
        
        Schema::table('pok_mata_anggaran', function (Blueprint $table) {
            $table->index(['id_program']);
            $table->index(['id_aktivitas']);
            $table->index(['id_kro']);
            $table->index(['id_ro']);
            $table->index(['id_komponen']);
            $table->index(['id_sub_komponen']);
            $table->index(['kode']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}