<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMstAlasanSiswaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('mst_alasan_siswa', function (Blueprint $table) {
            $table->increments('id'); 
            $table->integer('mst_alasan_soal_id'); // berisi alasan yg dipilih oleh user
            $table->integer('mst_user_id'); // relasi ke tabel user,level siswa
            $table->enum('is_yakin', [1,0])->default(0); //jika yakin nilainya adalah satu
            $table->string('komentar'); //komentar berfungsi saat koreksi jawaban
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
        //
    }
}
