{{-- mengambil alasan siswa berdasarkan id_soal dan id_user --}}
<?php //$alasan = $list->mst_alasan_siswa->alasan_siswa($list->id, \Auth::user()->id); ?>


Alasan yang dipilih : {{ count($alasan) }}
<br>
@if(count($alasan)>0)
	{{-- untuk menampilkan keyakinan dari alasan yang dipilih --}}
	@if($alasan->is_yakin == 1)
		<?php $keyakinan = "- YAKIN"; ?>
	@else
		<?php $keyakinan = "- TIDAK YAKIN"; ?>
	@endif

	@if($alasan->mst_alasan_soal->is_benar == 1 )
		<div style="color: Green;">
			{!! $alasan->mst_alasan_soal->alasan !!} - BENAR {!! $keyakinan !!}
		</div>
	@else 
		<div style="color: red;">
			{!! $alasan->mst_alasan_soal->alasan !!} - SALAH {!! $keyakinan !!}
		</div>
	@endif
@else 
	<div style="color: red;">
		belum memilih alasan
	</div>
@endif