
<?php $i = $soal->firstItem(); ?>

	<h3>Nama Siswa: {!! $user->nama !!}</h3>
	<hr>
<ol start="{!! $i !!}">
	
	@foreach($soal as $list)

	<li style="font-size:15px">
		<p>{!! $list->soal !!}</p>
		<img src="{{ asset('gambar_soal').'/'.$list->gambar_soal }}" class="img-fluid mx-auto d-block" alt='{{ $list->gambar_soal }}' >
	</li>
	<br> 
	 	
		<ol type="a">
			@foreach($list->mst_jawaban_soal as $list_jawaban)
				<li @if($list_jawaban->is_benar == 1) class="text-success"  @endif >
					{!! $list_jawaban->jawaban !!} <br>
					<img src="{{ asset('gambar_jawaban').'/'.$list_jawaban->gambar_jawaban }}" class="img-fluid mx-auto d-block" alt='{{ $list_jawaban->gambar_jawaban }}' >
				</li>
			@endforeach 		
		</ol>

	<div class="row">
		<div class="col-md-6">
			{{-- mengambil jawaban siswa berdasarkan id_soal dan id_user --}}
			<?php $jawaban = $jawaban_siswa->jawaban_siswa($list->id, $user->id); ?>
			@include($base_view.'lihat_hasil.komponen.jawaban_terpilih')
		</div>
	</div>
	<br>

		<ol type="a">
			@foreach($list->mst_alasan_soal as $list_alasan)
				<li @if($list_alasan->is_benar == 1) class="text-success"  @endif >
					{!! $list_alasan->alasan !!}
				</li>
			@endforeach 		
		 </ol>

	<div class="row">
		<div class="col-md-6">
			{{-- mengambil alasan siswa berdasarkan id_soal dan id_user --}}
			<?php $alasan = $alasan_siswa->alasan_siswa($list->id, $user->id); ?>
			@include($base_view.'lihat_hasil.komponen.alasan_terpilih')		
		</div>
	</div>

	<div class="row">
		<div class="col-md-6">
		@if(count($jawaban)>0 || count($alasan)>0)
			<?php 
				// untuk mengecek apakah jawaban siswa miskonsepsi atau tidak
				$miskonsepsi = $fungsi->cek_miskonsepsi($jawaban->mst_jawaban_soal->is_benar, $jawaban->is_yakin, $alasan->mst_alasan_soal->is_benar, $alasan->is_yakin);
			?>
			<div class="alert alert-success">
				<h3 style="text-align: center" >{!! $miskonsepsi !!}</h3>
		@else 
			<div class="alert alert-danger">
				<h3 style="text-align: center" >Belum Mengerjakan Soal</h3>
		@endif
			</div>
		</div>
	</div>
	<hr>

	<?php $i++; ?>
	@endforeach
</ol>


 {!! $soal->render() !!}