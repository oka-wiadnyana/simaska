@extends('layout.main')

@section('content')
<style>
    .text-wrap {
        white-space: normal;
        word-wrap: break-word;
    }

    /* .width-200 {
        width: 200px;
    } */
</style>
<div class="col bg-white shadow p-5">

    <h1>Daftar Nomor Surat Keputusan</h1>
    <div class="row mb-2">
        <div class="col">
            <button class="btn btn-primary tambah-surat-btn">Tambah SK</button>

            <button class="btn btn-success cetak-register">Cetak</button>

        </div>

    </div>
    <table class="table table-bordered data-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Nomor SK</th>
                <th>Tanggal SK</th>
                <th>Tentang</th>
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
    $(function () {
        
      var table = $('.data-table').DataTable({
          processing: true,
          serverSide: true,
          ajax: "{{ route('getskdata') }}",
          columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
              {data: 'nomor_sk', name: 'nomor_sk'},
              {data: 'tanggal_sk', name: 'tanggal_sk'},
              {data: 'tentang', name: 'tentang'},
              
              {data: 'action', name: 'action', orderable: false, searchable: false},
          ],
          columnDefs: [
                {
                    render: function (data, type, full, meta) {
                        return "<div class='text-wrap width-200'>" + data + "</div>";
                    },
                    targets: 3
                }
             ],
          responsive:true
      });
    //   new $.fn.dataTable.FixedHeader( table );
        
    });

    $('.tambah-surat-btn').click(function(e){
        e.preventDefault();
        
        $.ajax({
            type: "get",
            url: "{{ route('modaltambahsk') }}",
            data: "data",
            dataType: "json",
            success: function (response) {
                console.log(response.modal)
                $('.modal_container').html(response.modal);
                var modalTambahSurat = new bootstrap.Modal(document.querySelector('.modal_container .tambah_sk'));
                modalTambahSurat.show();

            }
        });

    })

    $('.cetak-register').click(function(e){
        e.preventDefault();
        
        $.ajax({
            type: "get",
            url: "{{ url('modalcetakregistersk') }}",
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
let id=$(this).data('id');
console.log(id);
$.ajax({
    type: "post",
    url: "{{ url('modaleditsk') }}",
    data: {
        id
    },
    dataType: "json",
    success: function (response) {
        console.log(response);
        $('.modal_container').html(response.modal);
                var modalEditSurat = new bootstrap.Modal(document.querySelector('.modal_container .edit_sk'));
                modalEditSurat.show();
    }
});
    })

    $('table tbody').on('click','.delete-btn', function(e){
e.preventDefault();
let id=$(this).data('id');
console.log(id);
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
    url: "{{ url('hapussk') }}",
    data: {
        id
    },
    dataType: "json",
    success: function (response) {
        console.log(response);
       $(location).attr('href','{{ url("surat_keputusan") }}')
    }
});
  }
})

    })

    $('table tbody').on('click','.arsip-btn', function(e){
e.preventDefault();
let id_surat=$(this).data('id');
console.log(id_surat);
Swal.fire({
  title: 'Apakah arsip sudah diterima?',
  text: "You won't be able to revert this!",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Ya, terima!',
  cancelButtonText:'Batal'
}).then((result) => {
  if (result.isConfirmed) {
    $.ajax({
    type: "post",
    url: "{{ url('terimaarsip') }}",
    data: {
        id_surat
    },
    dataType: "json",
    success: function (response) {
        console.log(response);
       $(location).attr('href','{{ url("mails") }}')
    }
});
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

    $('table tbody').on('click','.cetak-btn', function(e){
        e.preventDefault();
        let id_surat=$(this).data('id');
        console.log(id_surat);
        $.ajax({
            type: "post",
            url: "{{ url('modalcetaksurat') }}",
            data: {
                id_surat
            },
            dataType: "json",
            success: function (response) {
                console.log(response);
                $('.modal_container').html(response.modal);
                        var modalCetakSurat = new bootstrap.Modal(document.querySelector('.modal_container .cetak_surat'));
                        modalCetakSurat.show();
            }
        });

    })
</script>
@endsection