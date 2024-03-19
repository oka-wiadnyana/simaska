@extends('layout.main')

@section('content')

@push('thestyle')
@livewireStyles
@endpush
<div class="col bg-white shadow p-5">

    <h1>Referensi Barang</h1>
    <div class="row mb-2">
        <div class="col-md-6 d-flex">
            @livewire('buttontambah')
            <div class="col">

                <a href="" class="btn btn-info import-btn">Import Data</a>
            </div>
            <div class="col">

                <a href="" class="btn btn-danger hapus-all-btn">Hapus semua barang</a>
            </div>
        </div>

    </div>

    <table class="table table-bordered data-table" id="data-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Barang</th>
                <th>Satuan</th>
                <th>Kode</th>
                <th>Aksi</th>

            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>
<div>
    @livewire('refbarang')
</div>
<div>
    @livewire('modaleditbarang')
</div>


@push('thescript')
@livewireScripts
@endpush
<div id="modal-container">

</div>
<script type="text/javascript">
    $(function () {
        
      var table = $('.data-table').DataTable({
          processing: true,
          serverSide: true,
          ajax: "{{ route('getgoodsdata') }}",
          columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
              {data: 'nama_barang', name: 'nama_barang'},
              {data: 'satuan', name: 'satuan'},
              {data: 'kode_barang', name: 'kode_barang'},
            
              {data: 'action', name: 'action', orderable: false, searchable: false},
          ],
          responsive:true,
        //   deferLoading: true,
        drawCallback: function(settings) {
        if (window.livewire) {
            window.livewire.rescan();
        }
    }
      });
    //   new $.fn.dataTable.FixedHeader( table );
        
    });

    

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


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
            url: "{{ url('goods/delete_barang') }}",
            data: {
                id
            },
            dataType: "json",
            success: function (response) {
                console.log(response);
            $(location).attr('href','{{ url("goods") }}')
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

    $('.import-btn').click(function(e){
        e.preventDefault();
        $.ajax({
            type: "get",
            url: "{{ url('goods/modal_import') }}",
            
            dataType: "json",
            success: function (response) {
                 $('#modal-container').html(response.modal);
                var modal = new bootstrap.Modal(document.querySelector('#modal-container .modal_import'));
                modal.show();
            }
        });
    })

    $('.hapus-all-btn').click(function(e){
        e.preventDefault();
      
        Swal.fire({
        title: 'Anda yakin hapus semua data?',
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
            type: "get",
            url: "{{ url('goods/delete_all') }}",
            dataType: "json",
            success: function (response) {
                console.log(response);
            $(location).attr('href','{{ url("goods") }}')
            }
        });
        }
        })

    })
</script>
@endsection