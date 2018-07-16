<?php

namespace App\Models\Mst;

use App\Models\Mst\Soal;
use App\Models\Mst\AlasanSoal;
use Illuminate\Database\Eloquent\Model as Eloquent;

class AlasanSiswa extends Eloquent {
    protected $table = "mst_alasan_siswa";
    protected $fillable = [
        'mst_alasan_soal_id',
        'mst_user_id',
        'user_id',
        'is_yakin',
        'komentar',
        'mst_soal_id'
    ];

    public function mst_soal()
    {
    	return $this->belongsTo(Soal::class, 'mst_soal_id');
    }

    public function mst_alasan_soal()
    {
    	return $this->belongsTo(AlasanSoal::class, 'mst_alasan_soal_id');
    }

    /**
     * mencari alasan siswa berdasarkan id_soal dan id_user
     * FIXME: saat data kosong/tidak ditemukan maka akan eror
     */
    public function alasan_siswa($mst_soal_id, $mst_user_id){
        $jawaban_siswa = $this
                            ->where('mst_soal_id', '=', $mst_soal_id)           
                            ->where('mst_user_id', '=', $mst_user_id)
                            ->first();
        return $jawaban_siswa;
    }

    
}
