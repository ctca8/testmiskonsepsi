	Alasan yang dipilih : 
	<br>
	@if(count($list->mst_alasan_siswa)>0)
		{{-- untuk menampilkan keyakinan dari alasan yang dipilih --}}
		@if($list->mst_alasan_siswa->is_yakin == 1)
			<?php $keyakinan = "- YAKIN"; ?>
		@else
			<?php $keyakinan = "- TIDAK YAKIN"; ?>
		@endif

		@if($list->mst_alasan_siswa->mst_alasan_soal->is_benar == 1 )
			<div class="alert alert-success">
				{!! $list->mst_alasan_siswa->mst_alasan_soal->alasan !!} - BENAR {!! $keyakinan !!}
			</div>
		@else 
			<div class="alert alert-danger">
				{!! $list->mst_alasan_siswa->mst_alasan_soal->alasan !!} - SALAH {!! $keyakinan !!}
			</div>
		@endif
	@else 
		<div class="alert alert-danger">
			belum memilih alasan		
		</div>
	@endif
 