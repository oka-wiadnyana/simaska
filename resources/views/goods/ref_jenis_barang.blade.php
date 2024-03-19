@extends('layout.main')

@section('content')

<div class="col bg-white shadow p-5">

    <h1>Referensi Jenis Barang</h1>
    <div class="row mb-2">
        <div class="col">

            <a href="" class="btn btn-success btn-tambah-jenis">Tambah jenis barang</a>
        </div>

    </div>
    <table class="table table-bordered data-table" id="data-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode</th>
                <th>Uraian</th>
                <th>Aksi</th>

            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>
<div id="modal-wrapper">

</div>


<script type="text/javascript">
    $(function () {
        
      var table = $('.data-table').DataTable({
          processing: true,
          serverSide: true,
          ajax: "{{ route('getrefbarang') }}",
          columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
              {data: 'kode', name: 'kode'},
              {data: 'uraian', name: 'uraian'},
            
              {data: 'action', name: 'action', orderable: false, searchable: false},
          ],
          responsive:true,
        //   deferLoading: true,
        
      });
    //   new $.fn.dataTable.FixedHeader( table );
        
    });

    $('.btn-tambah-jenis').click(function(e){
        e.preventDefault();
        $.ajax({
            type: "get",
            url: "{{ url('goods/modal_tambah_jenis') }}",
            data: "",
            dataType: "json",
            success: function (response) {
                $('#modal-wrapper').html();
                $('#modal-wrapper').html(response.modal);
                var modal = new bootstrap.Modal(document.querySelector('#modal-wrapper .modal-tambah-jenis'));
                modal.show();
            }
        });
    })

    $('tbody').on('click','.edit-btn', function (e) { 
        e.preventDefault();
        let id=$(this).data('id');
        $.ajax({
            type: "post",
            url: "{{ url('goods/modal_edit_jenis') }}",
            data: {
                id
            },
            dataType: "json",
            success: function (response) {
                $('#modal-wrapper').html();
                $('#modal-wrapper').html(response.modal);
                var modal = new bootstrap.Modal(document.querySelector('#modal-wrapper .modal-edit-jenis'));
                modal.show();
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
                    url: "{{ url('goods/delete_jenis_barang') }}",
                    data: {
                        id
                    },
                    dataType: "json",
                    success: function (response) {
                        console.log(response);
                    $(location).attr('href','{{ url("goods/ref_jenis_barang") }}')
                    }
                });
            }
        })

    })

</script>
@endsection