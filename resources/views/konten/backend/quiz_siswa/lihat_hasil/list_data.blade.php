
<?php $i = $soal->firstItem(); ?>

<ol start="{!! $i !!}">
	
	@foreach($soal as $list)
		{{-- mengambil jawaban siswa berdasarkan id_soal dan id_user --}}
		<?php $jawaban = $list->mst_jawaban_siswa->jawaban_siswa($list->id, \Auth::user()->id); ?>
		{{-- mengambil alasan siswa berdasarkan id_soal dan id_user --}}
		<?php $alasan = $list->mst_alasan_siswa->alasan_siswa($list->id, \Auth::user()->id); ?>

	<li style="font-size:15px">
		{!! $list->soal !!}
	</li>
	<br> 
	 	<ul class="list-unstyled" style="margin-left : 2em;">
	 	<?php $no=1; ?>
			@foreach($list->mst_jawaban_soal as $list_jawaban)
				<li @if($list_jawaban->is_benar == 1) class="text-success"  @endif >
					{!! $fungsi->toAlpha($no).'. '.$list_jawaban->jawaban !!}
				</li> 
				<?php $no++; ?>
			@endforeach 		
	 	</ul>

	<div class="row">
		<div class="col-md-6">
			@include($base_view.'lihat_hasil.komponen.jawaban_terpilih')
		</div>
	</div>
	<br>

		<ul class="list-unstyled" style="margin-left : 2em;">
		<?php $no=1; ?>
		   @foreach($list->mst_alasan_soal as $list_alasan)
			   <li @if($list_alasan->is_benar == 1) class="text-success"  @endif >
				   {!! $fungsi->toAlpha($no).'. '.$list_alasan->alasan !!}
			   </li> 
			   <?php $no++; ?>
		   @endforeach 		
		</ul>

	<div class="row">
		<div class="col-md-6">
			@include($base_view.'lihat_hasil.komponen.alasan_terpilih')		
		</div>
	</div>

	<?php 
		// untuk mengecek apakah jawaban siswa miskonsepsi atau tidak
		$miskonsepsi = $fungsi->cek_miskonsepsi($jawaban->mst_jawaban_soal->is_benar, $jawaban->is_yakin, $alasan->mst_alasan_soal->is_benar, $alasan->is_yakin);
	?>
	<div class="row">
		<div class="col-md-6">
			<div class="alert alert-success">
				<h3 style="text-align: center" >{!! $miskonsepsi !!}</h3>
			</div>
		</div>
	</div>
	<hr>

	<?php $i++; ?>
	@endforeach
</ol>


 {!! $soal->render() !!}