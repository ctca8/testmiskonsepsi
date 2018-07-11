

<ul class="nav nav-tabs">
  <li role="presentation" @if(isset($lihat_hasil)) class="active" @endif>
  	<a href="{!! route('backend.quiz.manage_siswa.view_siswa_detail_nilai', [Request::segment(6), Request::segment(7)]) !!}">
  		Hasil Pengerjaan Soal
  	</a>
  </li>


  <li role="presentation" @if(isset($lihat_hasil_nilai)) class="active" @endif>
  	<a href="{!! route('backend.quiz.manage_siswa.view_siswa_hasil_nilai', [Request::segment(6), Request::segment(7)]) !!}">
  		Hasil Nilai
  	</a>
  </li>

</ul>