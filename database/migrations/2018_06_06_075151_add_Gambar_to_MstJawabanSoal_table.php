<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddGambarToMstJawabanSoalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mst_jawaban_soal', function (Blueprint $table) {
            $table->text('gambar_jawaban')->nullable()->after('jawaban');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mst_jawaban_soal', function (Blueprint $table) {
            
        });
    }
}
