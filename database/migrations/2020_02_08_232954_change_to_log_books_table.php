<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeToLogBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('log_books', function (Blueprint $table) {
            $table->string("hasil");
            $table->time('waktu_mulai');
            $table->time('waktu_selesai');
            $table->string("catatan_pimpinan");
            $table->dropColumn('is_approve');
            $table->dropColumn('catatan_approve');
            $table->dropColumn('waktu');
            $table->dropColumn('pimpinan_by');
            $table->dropColumn('flag_ckp');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('log_books', function (Blueprint $table) {
            //
        });
    }
}
