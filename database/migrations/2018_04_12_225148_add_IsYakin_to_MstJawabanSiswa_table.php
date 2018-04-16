<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIsYakinToMstJawabanSiswaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mst_jawaban_siswa', function (Blueprint $table) {
            $table->enum('is_yakin', [1,0])->default(0)->after('mst_user_id'); //jika yakin nilainya adalah satu
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
