<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMstSoalIdToMstAlasanSiswaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mst_alasan_siswa', function (Blueprint $table) {
            $table->integer('mst_soal_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mst_alasan_siswa', function (Blueprint $table) {
            $table->dropColumn('mst_soal_id');
        });
    }
}
