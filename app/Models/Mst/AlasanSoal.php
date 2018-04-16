<?php

namespace App;

use Illuminate\Database\Eloquent\Model as Eloquent;

class AlasanSoal extends Eloquent {
    protected $table = "mst_alasan_soal";
    protected $fillable = [
        'alasan',
        'is_benar',
        'mst_soal_id'
    ];

    
}
