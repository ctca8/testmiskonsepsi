<?php

namespace App\Http\Controllers\Backend;

use App\Helpers\Fungsi;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Http\Requests\Quiz\createJawabanSoal;
use App\Http\Requests\Quiz\createAlasanSoal;
use App\Http\Requests\Quiz\createSoalRequest;
use App\Http\Requests\Quiz\createTopikQuizRequest;
use App\Models\Mst\JawabanSiswa;
use App\Models\Mst\JawabanSoal;
use App\Models\Mst\AlasanSoal;
use App\Models\Mst\KelasUser;
use App\Models\Mst\Soal;
use App\Models\Mst\TopikSoal;
use App\Models\Mst\User;
use App\Models\Ref\Kelas;
use App\Models\Ref\TingkatKesulitan;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    private $base_view = 'konten.backend.quiz.';
    protected $kelas;
    protected $user;
    protected $tingkat_kesulitan;
    protected $topik_soal;
    protected $soal;
    protected $jawaban_soal;
    protected $alasan_soal;

    public function __construct(Kelas $kelas,
    							User $user, 
    							TingkatKesulitan $tingkat_kesulitan,
    							TopikSoal $topik_soal, 
    							Soal $soal, 
                                JawabanSoal $jawaban_soal,
                                AlasanSoal $alasan_soal
    							)
    {
    	$this->soal = $soal;
    	$this->tingkat_kesulitan = $tingkat_kesulitan;
    	view()->share('base_view', $this->base_view);
    	view()->share('backend_quiz_index', true);
    	$this->kelas = $kelas;
        $this->jawaban_soal = $jawaban_soal;
        $this->alasan_soal = $alasan_soal;
    	$this->user = $user;
    	$this->topik_soal = $topik_soal;
    }


    /**
     * menampilkan semua daftar topik
     * @return [type] [description]
     */
    public function index()
    {
    	$topik_quiz = $this->topik_soal
                           ->orderBy('id', 'DESC')
                           ->with('ref_kelas')
                           ->where('mst_user_id', '=', \Auth::user()->id)
                           ->paginate(10);
        $vars = compact('topik_quiz');
    	return view($this->base_view.'index', $vars);
    }

    /**
     * menambahkan topik
     * @param Fungsi $fungsi [description]
     */
    public function add(Fungsi $fungsi)
    {
    	$q_kelas = $this->kelas->where('mst_user_id', '=', \Auth::user()->id)->get();
    	$kelas = $fungsi->get_dropdown($q_kelas, 'kelas');
    	$q_tingkat_kesulitan = $this->tingkat_kesulitan->all();
    	$tingkat_kesulitan = $fungsi->get_dropdown($q_tingkat_kesulitan, 'tingkat kesulitan');
    	$vars = compact('kelas', 'tingkat_kesulitan');
    	return view($this->base_view.'popup.add', $vars);
    }

    /**
     * insert topik quiz
     * @param  createTopikQuizRequest $request [description]
     * @return [type]                          [description]
     */
    public function insert(createTopikQuizRequest $request)
    {
    	$insert = $this->topik_soal->create($request->except('_token'));
    	return $insert;
    }

    /**
     * edit topik quiz
     * @param  [type] $id     [description]
     * @param  Fungsi $fungsi [description]
     * @return [type]         [description]
     */
    public function edit($id, Fungsi $fungsi)
    {
    	$q_kelas = $this->kelas->where('mst_user_id', '=', \Auth::user()->id)->get();
    	$kelas = $fungsi->get_dropdown($q_kelas, 'kelas');
    	$q_tingkat_kesulitan = $this->tingkat_kesulitan->all();
    	$tingkat_kesulitan = $fungsi->get_dropdown($q_tingkat_kesulitan, 'tingkat kesulitan');
    	$topik = $this->topik_soal->findOrFail($id);
    	$vars = compact('kelas', 'tingkat_kesulitan', 'topik');
    	return view($this->base_view.'popup.edit', $vars);    	
    }

    /**
     * POST update topik quiz
     * @param  createTopikQuizRequest $request [description]
     * @return [type]                          [description]
     */
    public function update(createTopikQuizRequest $request)
    {
    	$update = $this->topik_soal
    		 		   ->where('id', '=', $request->id)
    		 		   ->update($request->except('_token'));
    	return $update;
    }

    /**
     * GET detail data topik
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function view_detail($id)
    {
    	$topik = $this->topik_soal->findOrFail($id);
    	return view($this->base_view.'popup.view_detail', compact('topik'));
    }


    /**
     * POST delete topik soal
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function delete(Request $request)
    {
        $ts = $this->topik_soal->findOrFail($request->id);
        //hapus daftar soal
        foreach($ts->mst_soal as $list){
            //hapus semua jawaban
            foreach($list->mst_jawaban_soal as $list_jawaban){
                $list_jawaban->delete();
            }
            $list->delete();
        }
        //hapus topik soal
        $ts->delete();
        return 'ok';
    }


    /**
     * menampilkan daftar soal yg ada di dlm topik
     * @param  [type] $mst_topik_soal_id [description]
     * @return [type]                    [description]
     */
    public function manage_soal($mst_topik_soal_id)
    {
    	$topik = $this->topik_soal->findOrFail($mst_topik_soal_id);
    	$q_soal = $this->soal
                     ->where('mst_topik_soal_id', '=', $mst_topik_soal_id)
                     ->with('mst_jawaban_soal')
                     ->orderBy('id', 'DESC')
                     ->paginate(10);
        $soal = $this->soal;
    	$vars = compact('topik', 'q_soal', 'soal');
    	return view($this->base_view.'manage_soal.index', $vars);
    }


    /**
     * GET menampilkan form add untuk tambah soal topik
     * @param  [type] $mst_topik_soal_id [description]
     * @return [type]                    [description]
     */
    public function manage_soal_add($mst_topik_soal_id){
        return view($this->base_view.'manage_soal.popup.add');
    }

    /**
     * @param  GET edit isi soal
     * @return [type]
     */
    public function manage_soal_edit($id)
    {
        $soal = $this->soal->findOrFail($id);
        $vars = compact('soal');
        return view($this->base_view.'manage_soal.popup.edit', $vars);
    }


    /**
     * @param  POST update isi soal
     * @return [type]
     */
    public function manage_soal_update(createSoalRequest $request)
    {
        /**
         * MOHON PERHATIAN
         * untuk edit soal belum dibuat penanganan untuk gambarnya ya.
         * jangan lupa untuk dikerjakan hlo ya.
         */
        
        $update = $this->soal->where('id', '=', $request->id)
                       ->update($request->except('_token'));
        return $update;
    }

    /**
     * POST insert data soal 
     * @param  createSoalRequest $request [description]
     * @return [type]                     [description]
     */
    public function manage_soal_insert(createSoalRequest $request)
    {
        // proses upload gambar_soal
        $gambar_soal = time().'.'.$request->gambar_soal->getClientOriginalExtension();
        $request->gambar_soal->move(public_path('gambar_soal'), $gambar_soal);
        
        // proses menyimpan gambar ke database
        // $insert = $this->soal->create($request->except('_token'));
        if($request->hasFile('gambar_soal')) {
            $insert = $this->soal->create([
                'soal' => $request->soal,
                'gambar_soal' => $gambar_soal,
                'mst_topik_soal_id' => $request->mst_topik_soal_id
            ]);
            return $insert;
            // return response()->json(['success'=>'Berhasil']);
        } else {
            // return response()->json(['error'=>$request->errors()->all()]);
            return $insert;
        }
        
        // // for debuging
        // $msg = array(
        //     'success' => true,
        //     'message' => "images uploaded",
        //     'gambar' => $gambar_soal,
        //     "soal" => $request->soal,
        //     "mst_topik_soal_id" => $request->mst_topik_soal_id,
        // );
        // exit(json_encode($msg));
    }

    /**
     * fungsi untuk menghapus soal
     */
    public function manage_soal_delete(Request $request)
    {
        $s = $this->soal->findOrFail($request->id);
        // menghapus gambar dari folder public
        $image_path = public_path().'/'.'gambar_soal'.'/'.$s->gambar_soal;
        unlink($image_path);
        // menghapus dari database
        $s->delete();
        return 'ok';
    }


    /**
     * form berisi penambahan jawaban soal
     * @param  [type] $mst_topik_soal_id [description]
     * @param  [type] $mst_soal_id       [description]
     * @return [type]                    [description]
     */
    public function manage_soal_add_jawaban($mst_topik_soal_id, $mst_soal_id, Fungsi $fungsi)
    {
        $soal = $this->soal->findOrFail($mst_soal_id);
        $vars = compact('soal', 'fungsi');
        return view($this->base_view.'manage_soal.popup.add_jawaban', $vars);
    }


    /**
     * insert jawaban untuk masing2 soal
     * @param  createJawabanSoal $request [description]
     * @return [type]                     [description]
     */
    public function manage_soal_insert_jawaban(createJawabanSoal $request)
    {
        \Session::flash('pesan_sukses', 'Jawaban telah berhasil ditambahkan');
        // $insert_jawaban = $this->jawaban_soal->create($request->except('_token'));

        // if($request->is_benar == 1){
        //     $all_js = $this->jawaban_soal->where('mst_soal_id', '=', $request->mst_soal_id)->get();
        //     foreach($all_js as $list){
        //         $list->is_benar = 0;
        //         $list->save();
        //     }
        //     $js = $this->jawaban_soal->findOrFail($insert_jawaban->id);
        //     $js->is_benar = 1;
        //     $js->save();
        // }

        // return $insert_jawaban;

        
                // proses menyimpan gambar ke database
        if($request->hasFile('gambar_jawaban')) {
            // proses upload gambar_soal
            $gambar_jawaban = time().'.'.$request->gambar_jawaban->getClientOriginalExtension();
            $request->gambar_jawaban->move(public_path('gambar_jawaban'), $gambar_jawaban);

            // insert dengan gambar
            $insert = $this->jawaban_soal->create([
                'mst_soal_id' => $request->mst_soal_id,
                'jawaban' => $request->jawaban,
                'gambar_jawaban' => $gambar_jawaban,
                'is_benar' => $request->is_benar,
            ]);

            // mengubah kunci jawaban
            if($request->is_benar == 1){
                $all_js = $this->jawaban_soal->where('mst_soal_id', '=', $request->mst_soal_id)->get();
                foreach($all_js as $list){
                    $list->is_benar = 0;
                    $list->save();
                }
                $js = $this->jawaban_soal->findOrFail($insert_jawaban->id);
                $js->is_benar = 1;
                $js->save();
            }

            return $insert;
            // return response()->json(['success'=>'Berhasil', 'gambar jawaban' => $gambar_jawaban]);
        } else {
            // insert tanpa gambar
            $insert = $this->jawaban_soal->create([
                'mst_soal_id' => $request->mst_soal_id,
                'jawaban' => $request->jawaban,
                'is_benar' => $request->is_benar,
            ]);

            // mengubah kunci jawaban
            if($request->is_benar == 1){
                $all_js = $this->jawaban_soal->where('mst_soal_id', '=', $request->mst_soal_id)->get();
                foreach($all_js as $list){
                    $list->is_benar = 0;
                    $list->save();
                }
                $js = $this->jawaban_soal->findOrFail($insert_jawaban->id);
                $js->is_benar = 1;
                $js->save();
            }

            return $insert;
            // return response()->json(['success'=>'Berhasil']);
        }

    }


    /**
     * POST hapus salah satu jawaban soal
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function manage_soal_del_jawaban(Request $request)
    {
        \Session::flash('pesan_sukses', 'data telah terhapus');
        $js = $this->jawaban_soal->findOrFail($request->id);
        $js->delete();
        return 'ok';
    }


    /**
     * GET edit salah satu jawaban soal
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function manage_soal_edit_jawaban($mst_topik_soal_id, $mst_soal_id, $id, Request $request, Fungsi $fungsi)
    {
        $jawaban = $this->jawaban_soal->findOrFail($id);
        $soal = $this->soal->findOrFail($mst_soal_id);
        $vars = compact('soal', 'fungsi', 'jawaban');
        return view($this->base_view.'manage_soal.popup.edit_jawaban', $vars);
    }


    /**
     * @param  POST update simpan soal jawaban
     * @return [type]
     */
    public function manage_soal_update_jawaban(Request $request)
    {
        /**
         * jika kunci jawaban mengalami perubahan
         * maka semua kunci jawaban awal diset menjadi 0 terlebih dahulu
         * agar tidak terjadi terdapat dua kunci jawaban
         */
        if($request->is_benar == 1){
            $all_jawaban = $this->jawaban_soal->where('mst_soal_id', '=', $request->mst_soal_id)->get();
            foreach($all_jawaban as $list){
                $list->is_benar = 0;
                $list->save();
            }
        }
        
        $update_jawaban = $this->jawaban_soal
                               ->where('id', '=', $request->id)
                               ->update($request->except('_token'));
        return $update_jawaban;
    }


      /**
     * POST set untuk memilih jawaban yg benar pada soal
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function manage_soal_set_jawaban_benar(Request $request)
    {

        $js = $this->jawaban_soal->findOrFail($request->id);

        $all_js = $this->jawaban_soal->where('mst_soal_id', '=', $js->mst_soal_id)->get();
        foreach($all_js as $list){
            $list->is_benar = 0;
            $list->save();
        }

        $js->is_benar = 1;
        $js->save();
        return 'ok';
    }

    
    /**
     * insert alasan untuk masing2 soal
     * @param  createAlasanSoal $request [description]
     * @return [type]                     [description]
     */
    public function manage_soal_insert_alasan(createAlasanSoal $request)
    {
        \Session::flash('pesan_sukses_alasan', 'Alasan telah berhasil ditambahkan');
        $insert_alasan = $this->alasan_soal->create($request->except('_token'));

        if($request->is_benar == 1){
            $all_js = $this->alasan_soal->where('mst_soal_id', '=', $request->mst_soal_id)->get();
            foreach($all_js as $list){
                $list->is_benar = 0;
                $list->save();
            }
            $js = $this->alasan_soal->findOrFail($insert_alasan->id);
            $js->is_benar = 1;
            $js->save();
        }

        return $insert_alasan;
    }


     /**
     * POST hapus salah satu alasan soal
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function manage_soal_del_alasan(Request $request)
    {
        \Session::flash('pesan_sukses_alasan', 'data telah terhapus');
        $js = $this->alasan_soal->findOrFail($request->id);
        $js->delete();
        return 'ok';
    }


     /**
     * GET edit salah satu alasan soal
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function manage_soal_edit_alasan($mst_topik_soal_id, $mst_soal_id, $id, Request $request, Fungsi $fungsi)
    {
        $alasan = $this->alasan_soal->findOrFail($id);
        $soal = $this->soal->findOrFail($mst_soal_id);
        $vars = compact('soal', 'fungsi', 'alasan');
        return view($this->base_view.'manage_soal.popup.edit_alasan', $vars);
    }


    /**
     * @param  POST update simpan alasan jawaban
     * @return [type]
     */
    public function manage_soal_update_alasan(Request $request)
    {
        /**
         * jika kunci jawaban mengalami perubahan
         * maka semua kunci jawaban awal diset menjadi 0 terlebih dahulu
         * agar tidak terjadi terdapat dua kunci jawaban
         */
        if($request->is_benar == 1){
            $all_alasan = $this->alasan_soal->where('mst_soal_id', '=', $request->mst_soal_id)->get();
            foreach($all_alasan as $list){
                $list->is_benar = 0;
                $list->save();
            }
        }
        
        $update_alasan = $this->alasan_soal
                               ->where('id', '=', $request->id)
                               ->update($request->except('_token'));
        return $update_alasan;
    }


      /**
     * POST set untuk memilih alasan yg benar pada soal
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function manage_soal_set_alasan_benar(Request $request)
    {
        // ambil data alasan_soal berdasarkan id_alasan_soal yang akan dijadikan kunci jawaban
        $js = $this->alasan_soal->findOrFail($request->id);

        // ambil semua data alasan berdasarkan id_soal untuk dilakukan pengeditan
        $all_js = $this->alasan_soal->where('mst_soal_id', '=', $js->mst_soal_id)->get();
        
        // semua nilai is_benar pada data_alasan diset menjadi 0 (salah)
        foreach($all_js as $list){
            $list->is_benar = 0;
            $list->save();
        }

        // data alasan_soal terpilih (dijadikan kunci jawaban) diset is_benar menjadi 1 (benar)
        $js->is_benar = 1;
        $js->save();
        return 'ok';
    }


    /**
     * GET action untuk melihat daftar siswa 
     * beserta nilainya di tiap2 topik yg ada
     * @param  [type] $mst_topik_soal_id [description]
     * @return [type]                    [description]
     */
    public function manage_siswa_view_nilai($mst_topik_soal_id, 
                                            KelasUser $kelas_user, 
                                            JawabanSiswa $jawaban_siswa,  
                                            Fungsi $fungsi
                                            )
    {
        $topik = $this->topik_soal->findOrFail($mst_topik_soal_id);
        $kelas_user = $kelas_user->where('ref_kelas_id', '=', $topik->ref_kelas_id)->get();
        $vars = compact('topik', 'kelas_user', 'jawaban_siswa', 'fungsi');
        return view($this->base_view.'popup.view_nilai_siswa', $vars);
    }


}
