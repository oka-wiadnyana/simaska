@extends('layout.main')

@section('content')
<div class="col bg-white shadow p-5">

    <h1>Daftar Permohonan Izin Keluar Kantor</h1>


    <table class="table table-bordered data-table">
        <thead>
            <tr>
                <th>No</th>

                <th>Pegawai</th>

                <th>Tanggal</th>
                <th>Pukul</th>
                <th>Alasan</th>
                <th>Status</th>
                <th>Aksi</th>

            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>
<div class="modal_container">

</div>




<script type="text/javascript">
    var table="";
    function getDataPermohonan () {
        
      table = $('.data-table').DataTable({
          processing: true,
          serverSide: true,
          ajax: `{{ url('permission/getdatapermohonan') }}`,
          columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
           
            
              {data: 'nama_pegawai', name: 'nama_pegawai'},
              
              {data: 'tanggal', name: 'tanggal'},
              {data: 'pukul', name: 'pukul'},
              {data: 'alasan', name: 'alasan'},
              {data: 'status', name: 'status'},
               
              {data: 'action', name: 'action', orderable: false, searchable: false},
          ],
          responsive:true
      });
    }
    //   new $.fn.dataTable.FixedHeader( table );
        
    getDataPermohonan();
    
    
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
  
    $('table tbody').on('click','.setuju-btn', function(e){
        e.preventDefault();
        let id=$(this).data('id');

        Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, setuju!',
        cancelButtonText:'Batal'
        }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
            type: "post",
            url: "{{ url('permission/setuju') }}",
            data: {
                id
            },
            dataType: "json",
            success: function (response) {
                console.log(response);
            $(location).attr('href','{{ url("permission/permohonan") }}')
            }
        });
        }
        })

    })

    $('table tbody').on('click','.tolak-btn', function(e){
        e.preventDefault();
        let id=$(this).data('id');

        Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, tolak!',
        cancelButtonText:'Batal'
        }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
            type: "post",
            url: "{{ url('permission/tolak') }}",
            data: {
                id
            },
            dataType: "json",
            success: function (response) {
                console.log(response);
            $(location).attr('href','{{ url("permission/permohonan") }}')
            }
        });
        }
        })

    })

    $('table tbody').on('click','.detail-btn', function(e){
        e.preventDefault();
        let id_leave=$(this).data('id');

            $.ajax({
            type: "post",
            url: "{{ url('leave/modaldetailgeneral') }}",
            data: {
                id_leave
            },
            dataType: "json",
            success: function (response) {
                $('.modal_container').html(response.modal);
                var modal = new bootstrap.Modal(document.querySelector('.modal_container .modal_detail'));
                modal.show();
            }

    })
})

$('table tbody').on('click','.nomor-cuti-btn', function(e){
        e.preventDefault();
        let id_leave=$(this).data('id');

            $.ajax({
            type: "post",
            url: "{{ url('leave/modalnomorcuti') }}",
            data: {
                id_leave
            },
            dataType: "json",
            success: function (response) {
                $('.modal_container').html(response.modal);
                var modal = new bootstrap.Modal(document.querySelector('.modal_container .modal_nomor_cuti'));
                modal.show();
            }

    })
})

    $('table tbody').on('click','.upload-btn', function(e){
e.preventDefault();
let id_surat=$(this).data('id');
let data_update=$(this).data('update');
let data_send={};
if(data_update){
    data_send={
        id_surat,
        data_update
    }
}else {
    data_send={
        id_surat,
         }
}
console.log(id_surat);
$.ajax({
    type: "post",
    url: "{{ url('modalupload') }}",
    data: data_send,
    dataType: "json",
    success: function (response) {
        console.log(response);
        $('.modal_container').html(response.modal);
                var modalUploadFile = new bootstrap.Modal(document.querySelector('.modal_container .upload_surat'));
                modalUploadFile.show();
    }
});


    })
</script>
@endsection