{{-- mengambil jawaban siswa berdasarkan id_soal dan id_user --}}
<?php //$jawaban = $list->mst_jawaban_siswa->jawaban_siswa($list->id, \Auth::user()->id); ?>

Jawaban yang dipilih : {{ count($jawaban) }}
<br>
@if(count($jawaban)>0)
	{{-- untuk menampilkan keyakinan dari jawaban yang dipilih --}}
	@if($jawaban->is_yakin == 1)
		<?php $keyakinan = "- YAKIN"; ?>
	@else
		<?php $keyakinan = "- TIDAK YAKIN"; ?>
	@endif

	@if($jawaban->mst_jawaban_soal->is_benar == 1 )
		<div style="color: Green;">
			{!! $jawaban->mst_jawaban_soal->jawaban !!} - BENAR {!! $keyakinan !!} <br>
			@if(isset($jawaban->mst_jawaban_soal->gambar_jawaban))
				<img src="{{ public_path('gambar_jawaban').'/'.$jawaban->mst_jawaban_soal->gambar_jawaban }}" alt='{{ $jawaban->mst_jawaban_soal->gambar_jawaban }}' style="width:150px;">
			@endif
		</div>
	@else 
		<div style="color: red;">
			{!! $jawaban->mst_jawaban_soal->jawaban !!} - SALAH	{!! $keyakinan !!} <br>
			@if(isset($jawaban->mst_jawaban_soal->gambar_jawaban))
				<img src="{{ public_path('gambar_jawaban').'/'.$jawaban->mst_jawaban_soal->gambar_jawaban }}" alt='{{ $jawaban->mst_jawaban_soal->gambar_jawaban }}' style="width:150px;">
			@endif
		</div>
	@endif
@else
	<div style="color: red;">
		belum memilih jawaban
	</div>
@endif