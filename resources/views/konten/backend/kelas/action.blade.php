 
<div class="dropdown">
  <a 
  	id="dLabel" 
  	data-target="#" 
  	href="http://example.com" 
  	data-toggle="dropdown" 
  	role="button" 
  	aria-haspopup="true" 
  	aria-expanded="false"
  	class="btn btn-primary" 
  	>
    Action 
    <span class="caret"></span>
  </a>

  <ul class="dropdown-menu" aria-labelledby="dLabel">
  	<li>@include($base_view.'action.siswa_kelas')</li>
  	 <li>@include($base_view.'action.regenerate_kode_kelas')</li>
  	 <li>@include($base_view.'action.manage_kelas')</li>
  	 <li>@include($base_view.'action.view_detail_kelas')</li>
  	<li>@include($base_view.'action.delete')</li>
  </ul>
</div>