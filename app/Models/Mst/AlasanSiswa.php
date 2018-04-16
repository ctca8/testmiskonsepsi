<?php

namespace App;

use Illuminate\Database\Eloquent\Model as Eloquent;

class AlasanSiswa extends Eloquent {
    protected $table = "mst_alasan_siswa";
    protected $fillable = [
        'mst_alasan_soal_id',
        'mst_user_id',
        'user_id',
        'is_yakin',
        'komentar'
    ];
    
}
