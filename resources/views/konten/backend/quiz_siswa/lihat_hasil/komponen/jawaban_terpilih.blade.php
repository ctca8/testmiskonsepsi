	Jawaban yang dipilih : <br>
	User id: {!! $list->mst_jawaban_siswa->mst_user_id !!} <br>
	User id saat ini: {!! \Auth::user()->id !!}
	<br>
	@if(count($list->mst_jawaban_siswa)>0) 
		{{-- untuk menampilkan keyakinan dari jawaban yang dipilih --}}
		@if($list->mst_jawaban_siswa->is_yakin == 1)
			<?php $keyakinan = "- YAKIN"; ?>
		@else
			<?php $keyakinan = "- TIDAK YAKIN"; ?>
		@endif
	
		@if($list->mst_jawaban_siswa->mst_jawaban_soal->is_benar == 1 )
			<div class="alert alert-success">
				{!! $list->mst_jawaban_siswa->mst_jawaban_soal->jawaban !!} - BENAR {!! $keyakinan !!}
			</div>
		@else 
			<div class="alert alert-danger">
				{!! $list->mst_jawaban_siswa->mst_jawaban_soal->jawaban !!}	- SALAH	{!! $keyakinan !!}
			</div>
		@endif
	@else
		<div class="alert alert-danger">
			belum memilih menjawab
		</div>
	@endif
 