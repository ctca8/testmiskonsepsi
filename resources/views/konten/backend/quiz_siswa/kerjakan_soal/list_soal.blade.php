<script type="text/javascript">
	
	// fungsi untuk mensubmit jawaban siswa
	function submit_jawaban(mst_soal_id, mst_jawaban_soal_id){
		form_data = {
			mst_soal_id : mst_soal_id,
			mst_jawaban_soal_id : mst_jawaban_soal_id,
			_token : '{!! csrf_token() !!}'
		}
		$.ajax({
			url : '{!! route("backend.quiz_siswa.submit_jawaban") !!}',
			data : form_data,
			type : 'post',
			error:function(err){
				swal('error', 'terjadi kesalahan pada sisi server!', 'error');
			},
			success:function(ok){

			}
		})
	}


	// fungsi untuk mensubmit alasan dari jawaban siswa
	function submit_alasan(mst_soal_id, mst_alasan_soal_id){
		form_data = {
			mst_soal_id : mst_soal_id,
			mst_alasan_soal_id : mst_alasan_soal_id,
			_token : '{!! csrf_token() !!}'
		}
		$.ajax({
			url : '{!! route("backend.quiz_siswa.submit_alasan") !!}',
			data : form_data,
			type : 'post',
			error:function(err){
				swal('error', 'terjadi kesalahan pada sisi server!', 'error');
			},
			success:function(ok){

			}
		})
	}

	// fungsi untuk mensubmit keyakinan jawaban siswa
	function submit_konfirmasi_jawaban(mst_soal_id, is_yakin){
		form_data = {
			mst_soal_id : mst_soal_id,
			is_yakin : is_yakin,
			_token : '{!! csrf_token() !!}'
		}
		$.ajax({
			url : '{!! route("backend.quiz_siswa.submit_konfirmasi_jawaban") !!}',
			data : form_data,
			type : 'post',
			error:function(err){
				swal('error', 'terjadi kesalahan pada sisi server!', 'error');
			},
			success:function(ok){

			}
		})
	}

	// fungsi untuk mensubmit keyakinan alasan siswa
	function submit_konfirmasi_alasan(mst_soal_id, is_yakin){
		form_data = {
			mst_soal_id : mst_soal_id,
			is_yakin : is_yakin,
			_token : '{!! csrf_token() !!}'
		}
		$.ajax({
			url : '{!! route("backend.quiz_siswa.submit_konfirmasi_alasan") !!}',
			data : form_data,
			type : 'post',
			error:function(err){
				swal('error', 'terjadi kesalahan pada sisi server!', 'error');
			},
			success:function(ok){

			}
		})
	}

 

$(function(){
    $('#nomor_soal').slimScroll({
        height: '400px',
        width : '80px',

    });
});
</script>



<div>
<div class="row">

	<div class="col-md-2" >
		<div id="nomor_soal">
		  <ul class="nav nav-pills nav-stacked" role="tablist">
		  <?php $no=1; ?>
			@foreach($soal as $list)
				    <li role="presentation" @if($no == 1) class="active" @endif >
				    	<a href="#soal{!! $no !!}" aria-controls="soal{!! $no !!}" role="tab" data-toggle="tab">
				    		{!! $no !!}
				    	</a>
				    </li>
					<?php $no++; ?>
			@endforeach
		  </ul>		
		</div>
	</div>
 
	<div class="col-md-10">
		 <!-- Tab panes -->
		  <div class="tab-content">
		  <?php $no=1; ?>
		@foreach($soal as $list)		  	
			@include($base_view.'kerjakan_soal.list_soal.detail_soal')
		<?php $no++; ?>
		@endforeach
		  </div>
		
	</div>
</div>

</div>