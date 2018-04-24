<div role="tabpanel" class="tab-pane fade @if($no == 1) in active @endif " id="soal{!! $no !!}"> 
	<h4>{!! $no.'. '.$list->soal !!}</h4> 
	<img src="{{ asset('gambar_soal').'/'.$list->gambar_soal }}" class="img-fluid mx-auto d-block" alt='{{ $list->gambar_soal }}' >
	<hr>

<ul style="margin-left:2em;" class="list-unstyled">
	<?php 
	$i=1; 
	if($topik_soal->is_jawaban_acak){
		$all_jawaban = $list->mst_jawaban_soal()->orderByRaw("RAND()")->get();
	}else{
		$all_jawaban = $list->mst_jawaban_soal()->orderBy("id", 'DESC')->get();
	}
	?>


	<div id="jawaban_soal{!! $list->id !!}">
		@foreach($all_jawaban as $list_jawaban)
			<li>  
				@include($base_view.'kerjakan_soal.list_soal.checkbox_jawaban')
				{!! $fungsi->toAlpha($i).'. '.$list_jawaban->jawaban !!}
			</li>
			<?php $i++; ?>
		@endforeach
	</div>
</ul>

<hr>
	{{-- menampilkan konfirmasi keyakinan dari jawaban yang dipilih siswa --}}
	@include($base_view.'kerjakan_soal.list_soal.checkbox_konfirmasi_jawaban')

<hr>

{{-- menampilkan alasan dari jawaban --}}
<div style="display: none;" id="form_alasan_no{!! $list->id !!}">
	<h4>Pilih alasan dari jawaban Anda</h4>
	<ul style="margin-left:2em;" class="list-unstyled">
		<?php 
		$i=1; 
		if($topik_soal->is_jawaban_acak){
			$all_alasan = $list->mst_alasan_soal()->orderByRaw("RAND()")->get();
		}else{
			$all_alasan = $list->mst_alasan_soal()->orderBy("id", 'DESC')->get();
		}
		?>


		<div id="alasan_soal_no{!! $list->id !!}">
			@foreach($all_alasan as $list_alasan)
				<li>
					@include($base_view.'kerjakan_soal.list_soal.checkbox_alasan')
					{!! $fungsi->toAlpha($i).'. '.$list_alasan->alasan !!}
				</li>
				<?php $i++; ?>
			@endforeach
		</div>
	</ul>
</div>

<script type="text/javascript">
	$('#form_konfirmasi_jawaban_no{!! $list->id !!}').click(function(){
		$('#form_alasan_no{!! $list->id !!}').fadeIn();
	});
</script>

<hr>
	{{-- menampilkan konfirmasi keyakinan dari alasan yang dipilih siswa --}}
	@include($base_view.'kerjakan_soal.list_soal.checkbox_konfirmasi_alasan')
	
</div>
