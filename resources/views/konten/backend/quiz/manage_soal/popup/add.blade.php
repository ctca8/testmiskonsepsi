<h3>
	Tambahkan Soal
</h3>
<hr>

<div class="row">
	<div class="col-md-12">
	{{-- id pesan di bawah ini belum digunakan --}}
	<div id="pesan"></div>

		<form id="uploadsoal" action="" method="post" enctype="multipart/form-data">
			{{ csrf_field() }}
			{!! Form::hidden('mst_topik_soal_id', Request::segment(5)) !!}
			<div class="form-group">
				{!! Form::label('soal', 'Isi Konten Soal ') !!}
				{!! Form::textarea('soal', '', ['id' => 'soal', 'class' => 'form-control', 'placeholder' => 'isi soal...']) !!}
			</div>	
			<div class="form-group">
				{!! Form::label('gambar_soal', 'Tambahkan Gambar ') !!}
				{!! Form::file('gambar_soal', ['id' => 'gambar_soal', 'class' => 'form-control']) !!}
			</div>
			<div class="form-group">
				<button type='submit' id='simpan' class='btn btn-info'><i class='fa fa-floppy-o'></i> SIMPAN</button>
			</div>
		</form>
	</div>
</div>

<script type="text/javascript">
	var form = document.querySelector('form');
	var request = new XMLHttpRequest();

	request.addEventListener('load', function(e){
		console.log(JSON.parse(e.target.responseText));
		swal({
			title : 'success',
			text : 'data telah tersimpan',
			type : 'success'
		}, function(){
			window.location.reload();
		});
	},false);

	form.addEventListener('submit', function(e){
		e.preventDefault();
		
		var formdata = new FormData(form); //formelement

		request.open('post', '{{ route("backend.quiz.manage_soal.insert") }}'); //route laravel
		request.send(formdata);

	},false);
</script>