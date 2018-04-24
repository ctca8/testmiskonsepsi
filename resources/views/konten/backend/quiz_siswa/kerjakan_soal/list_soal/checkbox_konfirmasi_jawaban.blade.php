<div style="display: none;" id="form_konfirmasi_jawaban_no{!! $list->id !!}">
	<h4>Apakah Anda yakin?</h4>	
	<ul style="margin-left:2em;" class="list-unstyled">
		<li>
		<input type="radio" 
			name="konfirmasi_jawaban_no{!! $list->id !!}"
			id="konfirmasi_jawaban_false_no{!! $list->id !!}"
			value="0"
			aria-label="..."
			@if(count($list_jawaban->mst_jawaban_siswa()->where('mst_user_id', '=', \Auth::user()->id)->first())>0)
				checked="true" 
			@endif
		> Tidak yakin
		</li>
		<li>
		<input type="radio" 
			name="konfirmasi_jawaban_no{!! $list->id !!}"
			id="konfirmasi_jawaban_true_no{!! $list->id !!}"
			value="1"
			aria-label="..."
			{{-- @if(count($list_jawaban->mst_jawaban_siswa()->where('mst_user_id', '=', \Auth::user()->id)->first())>0)
				checked="true" 
			@endif --}}
		> Yakin
		</li>
	</ul>
</div>

<script type="text/javascript">
	$('#jawaban_soal{!! $list->id !!}').click(function(){
		$('#form_konfirmasi_jawaban_no{!! $list->id !!}').fadeIn();
	});

	$('#konfirmasi_jawaban_true_no{!! $list->id !!}').click(function(){
		is_yakin = 1;
		submit_konfirmasi_jawaban({!! $list->id !!}, is_yakin);
	});

	$('#konfirmasi_jawaban_false_no{!! $list->id !!}').click(function(){
		is_yakin = 0;
		submit_konfirmasi_jawaban({!! $list->id !!}, is_yakin);
	});
</script>