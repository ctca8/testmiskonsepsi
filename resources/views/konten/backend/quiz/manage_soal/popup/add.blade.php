<h3>
	Tambahkan Soal
</h3>
<hr>

<div class="row">
	<div class="col-md-12">

	<div id="pesan"></div>

		<div class="form-group">
			{!! Form::label('soal', 'Isi Konten Soal ') !!}
			{!! Form::textarea('soal', '', ['id' => 'soal', 'class' => 'form-control', 'placeholder' => 'isi soal...']) !!}
		</div>	
		<div class="form-group">
			{!! Form::label('gambar_soal', 'Tambahkan Gambar ') !!}
			<!-- form upload gambar -->
			{!! Form::file('gambar_soal', ['id' => 'gambar_soal', 'class' => 'form-control']) !!}
		</div>
		<div class="form-group">
			<button id='simpan' class='btn btn-info'><i class='fa fa-floppy-o'></i> SIMPAN</button>
		</div>
	</div>
</div>




<script type="text/javascript">
$('#simpan').click(function(){
	$('#pesan').removeClass('alert alert-danger animated shake').html('');

var gambar_soal = $('#gambar_soal').prop('files')[0];
// var gambar_soal = $('#gambar_soal')[0].files[0];
var soal = $('#soal').val();

var form_data = new FormData();
// form_data.append('gambar_soal', gambar_soal);
// form_data.append('soal', soal);
// form_data.append('mst_topik_soal_id', {!! Request::segment(5) !!});
// form_data.append('_token', {!! csrf_token() !!});

// soal = $('#soal').val();

form_data ={
	soal : soal,
	gambar_soal : gambar_soal,
	mst_topik_soal_id : {!! Request::segment(5) !!},
 	_token : '{!! csrf_token() !!}'
}
$('#simpan').attr('disabled', 'disabled');
	$.ajax({
		url : '{{ route("backend.quiz.manage_soal.insert") }}',
		data : form_data,
		type : 'post',
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

</script>


