@extends('layout.main')

@section('content')
<div class="col bg-white shadow p-5">

    <h1>Daftar Bagian</h1>
    <div class="row mb-2">
        <div class="col">
            <button class="btn btn-primary tambah-unit-btn">Tambah Bagian</button>
        </div>
    </div>
    <table class="table table-bordered data-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Bagian</th>
                <th>Aksi</th>

            </tr>
        </thead>
        <tbody>
            @php
            $no=1;
            @endphp
            @foreach ( $units as $unit )
            <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $unit->nama_unit }}</td>

                <td><a class="btn btn-warning update-btn" data-id="{{ $unit->id }}" href="">Update</a>
                    <a class="btn btn-danger delete-btn" data-id="{{ $unit->id }}" href="">Delete</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="modal_container">

</div>


<script type="text/javascript">
    $(function () {
        
      var table = $('.data-table').DataTable({
        
          responsive:true
      });
    //   new $.fn.dataTable.FixedHeader( table );
        
    });

    $('.tambah-unit-btn').click(function(e){
        e.preventDefault();
        
        $.ajax({
            type: "get",
            url: "{{ url('modaltambahunit') }}",
            data: "data",
            dataType: "json",
            success: function (response) {
                console.log(response.modal)
                $('.modal_container').html(response.modal);
                var modalTambahJabatan = new bootstrap.Modal(document.querySelector('.modal_container .tambah_unit'));
                modalTambahJabatan.show();

            }
        });

    })

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('table tbody').on('click','.update-btn', function(e){
        e.preventDefault();
        let id_unit=$(this).data('id');

        $.ajax({
            type: "post",
            url: "{{ url('modaleditunit') }}",
            data: {
                id_unit
            },
            dataType: "json",
            success: function (response) {
                console.log(response);
                $('.modal_container').html(response.modal);
                        var modalEditUnit = new bootstrap.Modal(document.querySelector('.modal_container .edit_unit'));
                        modalEditUnit.show();
            }
        });
    })

    $('table tbody').on('click','.delete-btn', function(e){
        e.preventDefault();
        let id_unit=$(this).data('id');
        console.log(id_unit);
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
                    url: "{{ url('hapusunit') }}",
                    data: {
                        id_unit
                    },
                    dataType: "json",
                    success: function (response) {
                        console.log(response);
                    $(location).attr('href','{{ url("units") }}')
                    }
                });
            }
        })

    })

</script>
@endsection