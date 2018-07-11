@extends('layouts.backend')
@section('main')

	<div class="row">
		<button id='view_nilai{{ Request::segment(6) }}' class="btn btn-info pull-right">
			<i class='fa fa-bar-chart'></i> Daftar Siswa 
		</button>
	</div>
	
	<script type="text/javascript">
		$('#view_nilai{{ Request::segment(6) }}').click(function(){
			$('.modal-body').html('loading... <i class="fa fa-spinner fa-spin"></i>');
			$('#myModal').modal('show');
			$('.modal-body').load('{{ route("backend.quiz.manage_siswa.view_nilai", Request::segment(6)) }}')

		})
	</script>

	<h3 style="margin-top:0px;" class="text_header animated fadeInDown"> 
		<i class='fa fa-th-list'></i> Hasil Pengerjaan Tugas / Soal 
	</h3>
	<hr style="margin-top:0px;">

@include($base_view.'lihat_hasil_nilai.komponen.nav_atas')

<hr>

@include($base_view.'lihat_hasil.list_data')


@endsection