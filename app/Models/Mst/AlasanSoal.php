<?php

namespace App\Models\Mst;

use App\Models\Mst\Soal;
use App\Models\Mst\AlasanSiswa;
use Illuminate\Database\Eloquent\Model as Eloquent;

class AlasanSoal extends Eloquent {
    protected $table = 'mst_alasan_soal';
    protected $fillable = [
        'alasan',
        'is_benar',
        'mst_soal_id'
    ];

    public function mst_soal()
    {
        return $this->belongsTo(Soal::class, 'mst_soal_id');
    }

    public function mst_alasan_siswa()
    {
        return $this->hasOne(AlasanSiswa::class, 'mst_alasan_soal_id');
    }
    
}
