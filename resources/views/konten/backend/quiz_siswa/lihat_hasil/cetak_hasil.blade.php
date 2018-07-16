<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta ttp-equiv="Content-Type" content="text/html">
    <title>Download Hasil Nilai</title>
    <style>
        ul{
            list-style-type: none;
        }

        .page-break {
            page-break-after: always;
        }

        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
            font-size: 12pt;
        }

        td, th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        tr:nth-child(even) {
            background-color: #dddddd;
        }
    </style>
</head>
<body>
    <h3>Hasil Pengerjaan Tugas / Soal</h3>
    <p>Nama Siswa: {!! \Auth::user()->nama !!}</p>
    <p>Topik Quiz: {!! $topik_soal->nama !!}</p>
    <hr>

    <?php
        $is_miskonsepsi = 0;
        $is_paham = 0;
        $is_tidakpaham = 0;
        $is_error = 0;
    ?>
    <ol type="1">
        @foreach($soal as $list)
        <li style="font-size:15px">
            {!! $list->soal !!} <br>
            @if(isset($list->gambar_soal))
                <img src="{{ public_path('gambar_soal').'/'.$list->gambar_soal }}" alt='{{ $list->gambar_soal }}' style="width:250px;">
            @endif
        </li>
        <br> 
            <ol type="a">
                @foreach($list->mst_jawaban_soal as $list_jawaban)
                    <li @if($list_jawaban->is_benar == 1) style="color: Green;"  @endif >
                        {!! $list_jawaban->jawaban !!} <br>
                        @if(isset($list_jawaban->gambar_jawaban))
                            <img src="{{ public_path('gambar_jawaban').'/'.$list_jawaban->gambar_jawaban }}" alt='{{ $list_jawaban->gambar_jawaban }}' style="width:250px;">
                        @endif
                    </li>
                @endforeach 		
            </ol>

        <div class="row">
            <div class="col-md-6">
                <?php $jawaban= $jawaban->jawaban_siswa($list->id, \Auth::user()->id) ?>
                @include($base_view.'lihat_hasil.komponen.jawaban_terpilih')
            </div>
        </div>
        <br>

            <ol type="a">
            @foreach($list->mst_alasan_soal as $list_alasan)
                <li @if($list_alasan->is_benar == 1) style="color: Green;"  @endif >
                    {!! $list_alasan->alasan !!}
                </li>
            @endforeach 		
            </ol>

        <div class="row">
            <div class="col-md-6">
                <?php $alasan= $alasan->alasan_siswa($list->id, \Auth::user()->id) ?>
                @include($base_view.'lihat_hasil.komponen.alasan_terpilih')
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                @if(count($jawaban)>0 || count($alasan)>0)
                    <?php 
                        // untuk mengecek apakah jawaban siswa miskonsepsi atau tidak
                        $miskonsepsi = $fungsi->cek_miskonsepsi($jawaban->mst_jawaban_soal->is_benar, $jawaban->is_yakin, $alasan->mst_alasan_soal->is_benar, $alasan->is_yakin);
   
                        if ($miskonsepsi == "Paham") {
                            $is_paham++;
                        } elseif ($miskonsepsi == "Tidak Paham Konsep") {
                            $is_tidakpaham++;
                        } elseif ($miskonsepsi == "Miskonsepsi/Error") {
                            $is_error++;
                        } else {
                            $is_miskonsepsi++;
                        }
                    ?>
                    <div class="alert alert-success" style="background-color:DodgerBlue;">
                        <h3 style="text-align: center" >{!! $miskonsepsi !!}</h3>
                @else 
                    <?php $miskonsepsi = "belum mengerjakan"; ?>
                    <div class="alert alert-danger" style="background-color:Red;">
                        <h3 style="text-align: center" >Belum Mengerjakan Soal</h3>
                @endif
                    </div>
                </div>
            </div>
        <hr>
        @endforeach

    </ol>

    <div class="page-break"></div>

    <h4>Ringkasan Hasil Nilai</h4>

    <table class="table table-bordered">
        <tr>
            <td>
                Jumlah Soal			
            </td>
            <td class="text-center">
                <span class='label label-success'>
                    {!! count($soal) !!}					
                </span>
            </td>
        </tr>

        <tr>
            <td>
                Jumlah Jawaban Benar			
            </td>
            <td class="text-center">
                <span class='label label-success'>
                    {!! $total_jawaban_benar !!}
                </span>
            </td>
        </tr>

        <tr>
            <td>
                Nilai yg diperoleh			
            </td>
            <td class="text-center">
                <span class='label label-success'> 
                    @if($total_jawaban_benar > 0 )
                        {!! $fungsi->edit_angka($total_jawaban_benar * 100 / count($soal)) !!}
                    @else 
                        0 
                    @endif
                </span>
            </td>
        </tr>

    </table>

    <hr>

    <h4>Miskonsepsi</h4>

    <table class="table table-bordered">
		<tr>
			<td>
				Paham			
			</td>
			<td class="text-center">
				<span class='label label-primary'> 
					{!! $is_paham !!}
				</span>
			</td>
		</tr>

		<tr>
			<td>
				Tidak Paham Konsep
			</td>
			<td class="text-center">
				<span class='label label-warning'> 
					{!! $is_tidakpaham !!}
				</span>
			</td>
		</tr>

		<tr>
			<td>
				Miskonsepsi/Error
			</td>
			<td class="text-center">
				<span class='label label-info'> 
					{!! $is_error !!}
				</span>
			</td>
		</tr>

		<tr>
			<td>
				Miskonsepsi
			</td>
			<td class="text-center">
				<span class='label label-danger'> 
					{!! $is_miskonsepsi !!}
				</span>
			</td>
        </tr>
        
    </table>
    
</body>
</html>