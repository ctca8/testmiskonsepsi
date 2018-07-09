<?php //$jawaban = $list->mst_jawaban_siswa->jawaban_siswa($list->id, \Auth::user()->id) ?>
Jawaban yang dipilih :
<br>
@if(count($jawaban)>0)
	{{-- untuk menampilkan keyakinan dari jawaban yang dipilih --}}
	@if($jawaban->is_yakin == 1)
		<?php $keyakinan = "- YAKIN"; ?>
	@else
		<?php $keyakinan = "- TIDAK YAKIN"; ?>
	@endif

	@if($jawaban->mst_jawaban_soal->is_benar == 1 )
		<div class="alert alert-success">
			{!! $jawaban->mst_jawaban_soal->jawaban !!} - BENAR {!! $keyakinan !!}
		</div>
	@else 
		<div class="alert alert-danger">
			{!! $jawaban->mst_jawaban_soal->jawaban !!} - SALAH	{!! $keyakinan !!}
		</div>
	@endif
@else
	<div class="alert alert-danger">
		belum memilih jawaban
	</div>
@endif