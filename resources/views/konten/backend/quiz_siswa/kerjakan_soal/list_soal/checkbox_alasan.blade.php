<input type="radio" 
	   name="alasan_soal_no{!! $list->id !!}" 
	   id="alasan_soal_no{!! $list_alasan->id !!}" 
	   value="{!! $list_alasan->id !!}"
	   aria-label="..."
	   {{-- @if(count($list_alasan->mst_alasan_siswa()->where('mst_user_id', '=', \Auth::user()->id)->first())>0)
		   checked="true"
	   @endif --}}
>

<script type="text/javascript">

		$('#alasan_soal_no{!! $list_alasan->id !!}').click(function(){
			submit_alasan({!! $list->id !!}, {!! $list_alasan->id !!});
		});
</script>