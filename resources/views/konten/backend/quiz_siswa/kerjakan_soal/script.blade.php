<?php
    // mengambil waktu dari session
    $waktu_lama = Session::get('waktu_pengerjaan');
    // cek apakah sudah proses pengerjaan soal
    if(Session::has('waktu_pengerjaan')){
        // lanjutkan pengerjaan    
        $total_waktu = $waktu_lama;
    }else{
        // mulai awal
        $total_waktu = 0;
    }
?>



<button id="selesai" class="btn btn-success pull-right"> 
    <i class='fa fa-check'></i> SELESAI 
</button>


<h1>Sisa Waktu : <span id="countdown" class="timer"></span></h1>
<span style='display:none' id="countdown2" class="timer"></span>

<script>


$('#selesai').click(function(){
        $.ajax({
            url : '{!! route("backend.quiz_siswa.selesai_mengerjakan_soal") !!}',
            type : 'post',
            data : { _token : '{!! csrf_token() !!}', mst_topik_soal_id : {!! $topik_soal->id !!} },
            error:function(err){
                swal('error', 'terjadi kesalahan pada sisi serve', 'error');
            },
            success:function(ok){
               swal({
                title : 'selesai mengerjakan!',
                type : 'success'
               }, function(){
                    window.location.href = '{!! route("backend.quiz_siswa.quiz",  $topik_soal->ref_kelas->id) !!}'
               });
            }
        }); //ajax  
});

function toHHMMSS(seconds) {
    var h, m, s, result='';
    // HOURs
    h = Math.floor(seconds/3600);
    seconds -= h*3600;
    if(h){
        result = h<10 ? '0'+h+':' : h+':';
    }
    // MINUTEs
    m = Math.floor(seconds/60);
    seconds -= m*60;
    result += m<10 ? '0'+m+':' : m+':';
    // SECONDs
    s=seconds%60;
    result += s<10 ? '0'+s : s;
    return result;
}

var seconds = {{ $total_waktu }};

function secondPassed() {
    $('#countdown').html(toHHMMSS(seconds));
    document.getElementById('countdown2').innerHTML = seconds;
    if (seconds == 0) {
        // clearInterval(countdownTimer);
        // document.getElementById('countdown').innerHTML = "Selesai!!!";
        // clearInterval(UpdateSession); 

        $.ajax({
            url : '{!! route("backend.quiz_siswa.selesai_mengerjakan_soal") !!}',
            type : 'post',
            data : { _token : '{!! csrf_token() !!}', mst_topik_soal_id : {!! $topik_soal->id !!} },
            error:function(err){
                swal('error', 'terjadi kesalahan pada sisi serve', 'error');
            },
            success:function(ok){
               swal({
                title : 'waktu mengerjakan telah selesai!',
                type : 'success'
               }, function(){
                    window.location.href = '{!! route("backend.quiz_siswa.quiz",  $topik_soal->ref_kelas->id) !!}'
               });
            }
        }); //ajax  
        
    } else {
        seconds--;
    }

 

}




function update_session(){
        value = $('#countdown2').text();
        form_data = {
                value : value,
                _token : '{!! csrf_token() !!}'
        }
        $.ajax({
                url : '{{ route("backend.quiz_siswa.update_timer_soal") }}',
                data : form_data,
                type : 'post',
                success:function(ok){
                        
                }
        })
}

var countdownTimer = setInterval('secondPassed()', 1000);
var UpdateSession = setInterval('update_session()', 10000);    

</script>