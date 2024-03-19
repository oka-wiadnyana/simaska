@extends('layout.main')

@section('content')
<div class="col bg-white shadow p-5">

    <h1>Daftar Izin Keluar Kantor {{ isset($umum)?'Umum':session('employee_name') }} </h1>

    <div class="row mb-2">
        <div class="col">
            <button class="btn btn-primary tambah-btn">Tambah Izin</button>
            @if(isset($umum))
            <button class="btn btn-success cetak-register">Cetak</button>
            @endif
        </div>

    </div>
    <table class="table table-bordered data-table">
        <thead>
            <tr>
                <th>No</th>
                @if(isset($umum))
                <th>Pegawai</th>
                @endif
                <th>Atasan</th>
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
    @if(isset($umum))
    let urlDatatable="{{ url('getpermission') }}"
    @else
    let urlDatatable="{{ url('getpermission/'.session('employee_nip')) }}"
    @endif
    // var table="";
   
    var table="";
    function getDataPermission (kategori=null) {
        
      table = $('.data-table').DataTable({
          processing: true,
          serverSide: true,
          ajax: `${urlDatatable}`,
          columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
           
                @if(isset($umum))
            
                {data: 'nama_pegawai', name: 'nama_pegawai'},
                @endif
              {data: 'nama_atasan', name: 'nama_atasan'},
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
        
    getDataPermission();
    
    $('.tambah-btn').click(function(e){
        e.preventDefault();
        @if(isset($umum))
        let jenis='umum'
        @else
        let jenis='pribadi'
        @endif
        $.ajax({
            type: "get",
            url: `{{ url('permission/modalinsert/') }}/${jenis}`,
           
            dataType: "json",
            success: function (response) {
                console.log(response.modal)
                $('.modal_container').html(response.modal);
                var modalTambahSurat = new bootstrap.Modal(document.querySelector('.modal_container .modal_tambah'));
                modalTambahSurat.show();

            }
        });

    })

    $('.cetak-register').click(function(e){
        e.preventDefault();
        
        $.ajax({
            type: "get",
            url: "{{ url('permission/modalcetakregister') }}",
            data: "data",
            dataType: "json",
            success: function (response) {
                console.log(response.modal)
                $('.modal_container').html(response.modal);
                var modalCetak = new bootstrap.Modal(document.querySelector('.modal_container .cetak_register'));
                modalCetak.show();

            }
        });

    })


    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('table tbody').on('click','.edit-btn', function(e){
e.preventDefault();
let id_permission=$(this).data('id');
console.log(id_permission);
$.ajax({
    type: "post",
    url: "{{ url('permission/modaledit') }}",
    data: {
        id_permission
    },
    dataType: "json",
    success: function (response) {
        console.log(response);
        $('.modal_container').html(response.modal);
                var modal = new bootstrap.Modal(document.querySelector('.modal_container .modal_edit'));
                modal.show();
    }
});
    })

    $('table tbody').on('click','.delete-btn', function(e){
e.preventDefault();
let id=$(this).data('id');

Swal.fire({
  title: 'Are you sure?',
  text: "You won't be able to revert this!",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Ya, hapus!',
  cancelButtonText:'Batal'
}).then((result) => {
  if (result.isConfirmed) {
    $.ajax({
    type: "post",
    url: "{{ url('permission/delete') }}",
    data: {
        id
    },
    dataType: "json",
    success: function (response) {
        console.log(response);
       $(location).attr('href','{{ url("permission") }}')
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