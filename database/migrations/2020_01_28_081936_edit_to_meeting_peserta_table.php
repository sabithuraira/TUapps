<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditToMeetingPesertaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('meeting_peserta', function (Blueprint $table) {
            $table->dropColumn('nip_lama_id');
            $table->string('nip_baru');
            $table->string('name');
            $table->string('nmjab');
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
