<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SetNullToMeetingPesertaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('meeting_peserta', function (Blueprint $table) {
            $table->dropIndex('meeting_peserta_pegawai_id_foreign');

            $table->string('pegawai_id')->nullable()->change();
            $table->string('nip_baru')->nullable()->change();
            $table->string('name')->nullable()->change();
            $table->string('nmjab')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('meeting_peserta', function (Blueprint $table) {
            //
        });
    }
}
