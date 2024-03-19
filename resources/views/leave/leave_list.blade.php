@extends('layout.main')

@section('content')
<div class="col bg-white shadow p-5">

    <h1>Daftar Cuti {{ $jenis=='user'?session('employee_name'):'Umum' }} </h1>
    @if((Session::get('kepegawaian')==true)&&Request::segment(1)=='leave')
    <div class="row mb-2">
        <form action="{{ url('leave/cetakrekapsaldocuti') }}" method="post" target="_blank" class="m-0 p-0">
            @csrf
            <div class="col-md-4 d-md-flex gap-2">

                <select name="kategori_select" id="" class="form-control">
                    <option value="" selected disabled>Pilih kategori</option>
                    <option value="semua">Semua</option>
                    <option value="acc_ats">Acc ats</option>
                    <option value="acc_kpn">Acc kpn</option>
                    <option value="reject_ats">Tolak ats</option>
                    <option value="reject_kpn">Tolak kpn</option>
                    <option value="ditangguhkan_ats">Ditangguhkan ats</option>
                    <option value="ditangguhkan_kpn">Ditangguhkan kpn</option>
                </select>


                <button class="btn btn-info submit_kategori" disabled>Submit</button>


            </div>
        </form>


    </div>
    @endif
    <div class="row mb-2">
        <div class="col">
            <button class="btn btn-primary tambah-btn">Tambah Cuti</button>
            @if((Session::get('kepegawaian')==true)&&Request::segment(1)=='leave')
            <button class="btn btn-success cetak-register">Cetak</button>
            @endif
        </div>

    </div>
    <table class="table table-bordered data-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode</th>
                <th>Tgl Pengajuan</th>
                <th>Jenis Cuti</th>
                @if(Session::get('kepegawaian')==true)
                <th>Pegawai</th>
                @endif
                <th>Tgl Awal</th>
                <th>TglAkhir</th>
                <th>Hari Efektif</th>
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
    @if(Request::segment(1)=='leave_user')
        let urlDatatable="{{ url('getleavesgeneral/'.session('employee_nip')) }}"
    @endif
    @if(Request::segment(1)=='leave')
        @if(Session::get('kepegawaian')==true)
        let urlDatatable="{{ url('getleavesgeneral/null') }}"
        @endif
    @endif
   
    // var table="";
   
    var table="";
    function getDataLeave (kategori=null) {
        
      table = $('.data-table').DataTable({
          processing: true,
          serverSide: true,
          ajax: `${urlDatatable}/${kategori}`,
          columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
              {data: 'kode_cuti', name: 'kode_cuti'},
              {data: 'tgl_pengajuan', name: 'tgl_pengajuan'},
              {data: 'jenis', name: 'jenis'},
              @if(Session::get('kepegawaian')==true)
              {data: 'nama', name: 'nama'},
              @endif
              {data: 'tgl_mulai', name: 'tgl_mulai'},
              {data: 'tgl_akhir', name: 'tgl_akhir'},
              {data: 'hari_efektif', name: 'hari_efektif'},
              {data: 'status', name: 'status'},           
              {data: 'action', name: 'action', orderable: false, searchable: false},
          ],
          responsive:true
      });
    }
    //   new $.fn.dataTable.FixedHeader( table );
        
    getDataLeave();
    $('[name="kategori_select"]').change(function (e) { 
        $('.submit_kategori').removeAttr('disabled');

     })
     $('.submit_kategori').click(function(e){
        e.preventDefault();
        let kategori= $('[name="kategori_select"]').val();
        table.destroy();
        getDataLeave(kategori);

     })

    $('.tambah-btn').click(function(e){
        e.preventDefault();
        
        $.ajax({
            type: "get",
            url: "{{ route('modalinsertgeneral') }}",
           
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
            url: "{{ url('leave/modalcetakregister') }}",
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
let id_leave=$(this).data('id');
console.log(id_leave);
$.ajax({
    type: "post",
    url: "{{ url('leave/modaleditgeneral') }}",
    data: {
        id_leave
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
let id_leave=$(this).data('id');
console.log(id_leave);
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
    url: "{{ url('leave/deletegeneral') }}",
    data: {
        id_leave
    },
    dataType: "json",
    success: function (response) {
        console.log(response);
       $(location).attr('href','{{ url("leave") }}')
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