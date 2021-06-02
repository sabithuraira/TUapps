<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePenugasanParticipantTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penugasan_participant', function (Blueprint $table) {
            $table->increments('id');

            $table->integer("penugasan_id");
            $table->integer("user_id");
            $table->string("user_nip_lama");
            $table->integer("jumlah_target");
            $table->integer("jumlah_selesai");
            $table->char('unit_kerja', 4);
            $table->integer('nilai_waktu');
            $table->integer('nilai_penyelesaian');

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
        Schema::dropIfExists('penugasan_participant');
    }
}
