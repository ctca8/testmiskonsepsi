<h3>
	Tambahkan Soal
</h3>
<hr>

<div class="row">
	<div class="col-md-12">

	<div id="pesan"></div>

		<form id="uploadsoal" action="{{ route('backend.quiz.manage_soal.insert') }}" method="POST" enctype="multipart/form-data">
			{{ csrf_field() }}
			{!! Form::hidden('mst_topik_soal_id', Request::segment(5)) !!}
		<div class="form-group">
			{!! Form::label('soal', 'Isi Konten Soal ') !!}
			{!! Form::textarea('soal', '', ['id' => 'soal', 'class' => 'form-control', 'placeholder' => 'isi soal...']) !!}
		</div>	
		<div class="form-group">
			{!! Form::label('gambar_soal', 'Tambahkan Gambar ') !!}
			<!-- form upload gambar -->
			{!! Form::file('gambar_soal', ['id' => 'gambar_soal', 'class' => 'form-control']) !!}
		</div>
		{{-- <div class="form-group">
			<!-- The global progress bar -->
			<div id="progress" class="progress">
				<div class="progress-bar progress-bar-success"></div>
			</div>
			<!-- The container for the uploaded files -->
			<div id="files" class="files"></div>
		</div> --}}
		<div class="form-group">
			<button id='simpan' class='btn btn-info'><i class='fa fa-floppy-o'></i> SIMPAN</button>
		</div>
		</form>
	</div>
</div>

{{-- <script src="{{ asset('/plugins/blueimp/vendor/jquery.ui.widget.js') }}"></script>
<script src="{{ asset('/plugins/blueimp/jquery.fileupload.js') }}"></script>
<script src="{{ asset('/plugins/blueimp/jquery.iframe-transport.js') }}"></script>

<!-- upload file dengan blueimp plugins -->
<script type="text/javascript">
	$(function () {
		'use strict';
		// Change this to the location of your server-side upload handler:
		var url = '{{ route("backend.quiz.manage_soal.insert") }}';
		$('#gambar_soal').fileupload({
			url: url,
			dataType: 'json',
			done: function (e, data) {
				$.each(data.result.files, function (index, file) {
					$('<p/>').text(file.name).appendTo('#files');
				});
				alert("berhasil"); //untuk test apakah fungsi done dijalankan atau tidak
			},
			progressall: function (e, data) {
				var progress = parseInt(data.loaded / data.total * 100, 10);
				$('#progress .progress-bar').css(
					'width',
					progress + '%'
				);
			}
		}).prop('disabled', !$.support.fileInput)
			.parent().addClass($.support.fileInput ? undefined : 'disabled');
	});
</script> --}}


<!-- upload file dengan ajax. sudah berhasil tapi jelek -->
<script type="text/javascript">
	// $("body").on("click","#simpan",function(e){
	$("#simpan").click(function(){
		$(this).parents("form").ajaxForm(options);
	});

	var options = { 
		complete: function(response) 
		{
			if($.isEmptyObject(response.responseJSON.error)){
				$("input[name='soal']").val('');
				alert('Upload gambar berhasil.');
				// window.location.reload();
			}else{
				printErrorMsg(response.responseJSON.error);
			}
		}
	};

	function printErrorMsg (msg) {
		$("#pesan").find("ul").html('');
		$("#pesan").css('display','block');
		$.each( msg, function( key, value ) {
			$("#pesan").find("ul").append('<li>'+value+'</li>');
		});
	}
	
</script>

<!-- tambah soal dengan ajax tanpa upload file -->
<!-- <script type="text/javascript">
$('#simpan').click(function(){
// $('#simpan').on("click", function(){
	$('#pesan').removeClass('alert alert-danger animated shake').html('');

// var gambar_soal = $("#gambar_soal")[0];
// var soal = $('#soal').val();

// var form_data = new FormData();

// form_data ={
// 	soal : soal,
// 	gambar_soal : gambar_soal,
// 	mst_topik_soal_id : {!! Request::segment(5) !!},
//  	_token : '{!! csrf_token() !!}'
// }

// var form_data = $('#uploadsoal').serialize();

$('#simpan').attr('disabled', 'disabled');
	$.ajax({
		url : '{{ route("backend.quiz.manage_soal.insert") }}',
		data : form_data,
		type : 'post',
		// cache: false,
		// contentType: false,
		// processData: false,
		error:function(xhr, status, error){
			$('#simpan').removeAttr('disabled');
		 	$('#pesan').addClass('alert alert-danger animated shake').html('<b>Error : </b><br>');
	        datajson = JSON.parse(xhr.responseText);
	        $.each(datajson, function( index, value ) {
	       		$('#pesan').append(index + ": " + value+"<br>")
	         });

		      //    alert('error! terjadi kesalahan pada sisi server!')
		},
		success:function(ok){
			 //window.location.reload(); 
			 swal({
			 	title : 'success',
			 	text : 'data telah tersimpan',
			 	type : 'success'
			 }, function(){
			 	window.location.reload();
			 });
		}
	})
})



$('#pesan').click(function(){
	$('#pesan').fadeOut(function(){
		$('#pesan').html('').show().removeClass('alert alert-danger');
	});
})

</script> -->


