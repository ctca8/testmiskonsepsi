<?php

namespace App\Models\Mst;

use App\Models\Mst\Soal;
use App\Models\MSt\AlasanSoal;
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


    // public function total_alasan_benar($mst_user_id, $mst_topik_soal_id)
    // {
    //     $jawaban_benar = 0; 

    //     $soal = Soal::where('mst_topik_soal_id', '=', $mst_topik_soal_id)->get();
    //          foreach($soal as $list){
    //            if(count($list->mst_jawaban_siswa)>0){
    //             if($list->mst_jawaban_siswa->mst_jawaban_soal->is_benar == 1 ){
    //                 $jawaban_benar = $jawaban_benar+1;
    //             }
    //            }

    //          }

 
    //     return $jawaban_benar;

    // } 
    
}
