@extends('layouts.backend')
@section('main')

	<div class="row">
		<button id='view_nilai{{ Request::segment(6) }}' class="btn btn-info pull-right">
			<i class='fa fa-bar-chart'></i> Daftar Siswa 
		</button>
	</div>

	<script type="text/javascript">
		$('#view_nilai{{ Request::segment(6) }}').click(function(){
			$('.modal-body').html('loading... <i class="fa fa-spinner fa-spin"></i>');
			$('#myModal').modal('show');
			$('.modal-body').load('{{ route("backend.quiz.manage_siswa.view_nilai", Request::segment(6)) }}')

		})
	</script>

	<h3 style="margin-top:0px;" class="text_header animated fadeInDown"> 
		<i class='fa fa-th-list'></i> Hasil Pengerjaan Tugas / Soal 
	</h3>
	<hr style="margin-top:0px;">

@include($base_view.'lihat_hasil_nilai.komponen.nav_atas')

<hr>

<div class="col-md-6">
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

	{{-- table Miskonsepsi --}}
	<?php
		$is_miskonsepsi = 0;
		$is_paham = 0;
		$is_tidakpaham = 0;
		$is_error = 0;
	?>
	@foreach($soal as $list)
		<?php 
			// mengambil jawaban siswa berdasarkan id_soal dan id_user
			$jawaban = $jawaban_siswa->jawaban_siswa($list->id, $siswa->id);
			// mengambil alasan siswa berdasarkan id_soal dan id_user
			$alasan = $alasan_siswa->alasan_siswa($list->id, $siswa->id);

			// untuk mengecek apakah jawaban siswa miskonsepsi atau tidak
			if (count($jawaban)>0 || count($alasan)>0) {
				$miskonsepsi = $fungsi->cek_miskonsepsi($jawaban->mst_jawaban_soal->is_benar, $jawaban->is_yakin, $alasan->mst_alasan_soal->is_benar, $alasan->is_yakin);
			} else {
				//nilai default jika tidak dikerjakan
				$miskonsepsi = "belum mengerjakan";
			}

			if ($miskonsepsi == "Paham") {
				$is_paham++;
			} elseif ($miskonsepsi == "Tidak Paham Konsep") {
				$is_tidakpaham++;
			} elseif ($miskonsepsi == "Miskonsepsi/Error") {
				$is_error++;
			} elseif ($miskonsepsi == "Miskonsepsi") {
				$is_miskonsepsi++;
			}
		?>
	@endforeach

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

	<div class="row">
		<a href="{!! route('backend.quiz_siswa.cetak_hasil_nilai', Request::segment(4)) !!}" class="btn btn-warning">
			<i class='fa fa-print'></i> Cetak Nilai
		</a>	
	</div>
</div>


@endsection