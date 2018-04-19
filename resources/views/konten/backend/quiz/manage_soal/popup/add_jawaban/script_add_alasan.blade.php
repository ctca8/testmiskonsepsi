<script type="text/javascript">

    $('#create_alasan').click(function(){
        $('#create_alasan').hide();
        $('#form_tambah_alasan').fadeIn();
    });
    
    $('#cancel_alasan').click(function(){
        $('#form_tambah_alasan').hide();
        $('#create_alasan').fadeIn();
    });
    
    
    $('#simpan_alasan').click(function(){
        $('#pesan_alasan').removeClass('alert alert-danger animated shake').html('');
        alasan = $('#alasan').val();
        is_benar = $('#is_benar_alasan').val();

        form_data ={
            alasan : alasan,
            is_benar : is_benar,
            mst_soal_id : {!! Request::segment(6) !!},
            _token : '{!! csrf_token() !!}'
        }
        $('#simpan_alasan').attr('disabled', 'disabled');
        $.ajax({
            url : '{{ route("backend.quiz.manage_soal.insert_alasan") }}',
            data : form_data,
            type : 'post',
            error:function(xhr, status, error){
                $('#simpan_alasan').removeAttr('disabled');
                $('#pesan_alasan').addClass('alert alert-danger animated shake').html('<b>Error : </b><br>');
            datajson = JSON.parse(xhr.responseText);
            $.each(datajson, function( index, value ) {
                   $('#pesan_alasan').append(index + ": " + value+"<br>")
              });
            },
            success:function(ok){
                 swal({
                     title : 'success',
                     type : 'success'
                 }, function(){
                    $('.modal-body').load('{!! route("backend.quiz.manage_soal.add_jawaban", [Request::segment(5), Request::segment(6)]) !!}')
                    $('#myModal').on('hidden.bs.modal', function (e) {
                        window.location.reload();
                    });					 
                 });
            }
        });
    });
    
    
    
    $('#pesan_alasan').click(function(){
        $('#pesan_alasan').fadeOut(function(){
            $('#pesan_alasan').html('').show().removeClass('alert alert-danger');
        });
    })
    
</script>
    