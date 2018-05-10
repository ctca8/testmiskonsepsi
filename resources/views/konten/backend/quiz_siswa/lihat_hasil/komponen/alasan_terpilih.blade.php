<?php $alasan = $list->mst_alasan_siswa->alasan_siswa($list->id, \Auth::user()->id) ?>
Alasan yang dipilih :
<br>
@if(count($alasan)>0)
	{{-- untuk menampilkan keyakinan dari alasan yang dipilih --}}
	@if($alasan->is_yakin == 1)
		<?php $keyakinan = "- YAKIN"; ?>
	@else
		<?php $keyakinan = "- TIDAK YAKIN"; ?>
	@endif

	@if($alasan->mst_alasan_soal->is_benar == 1 )
		<div class="alert alert-success">
			{!! $alasan->mst_alasan_soal->alasan !!} - BENAR {!! $keyakinan !!}
		</div>
	@else 
		<div class="alert alert-danger">
			{!! $alasan->mst_alasan_soal->alasan !!} - SALAH {!! $keyakinan !!}
		</div>
	@endif
@else 
	<div class="alert alert-danger">
		belum memilih alasan		
	</div>
@endif
 