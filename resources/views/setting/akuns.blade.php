@extends('layout.main')

@section('content')
<div class="col bg-white shadow p-5">

    <h1>Daftar Akun</h1>
    <div class="row mb-2">
        <div class="col">
            <button class="btn btn-primary tambah-akun-btn">Tambah Akun</button>
        </div>
    </div>
    <table class="table table-bordered data-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>NIP</th>
                <th>Jabatan</th>
                <th>Username</th>
                <th>Level</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @php
            $no=1;
            @endphp
            @foreach ( $akuns as $akun )
            <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $akun->nama }}</td>
                <td>{{ $akun->nip }}</td>
                <td>{{ $akun->nama_jabatan }}</td>
                <td>{{ $akun->username }}</td>
                <td>{{ $akun->nama_level }}</td>
                <td>
                    <a class="btn btn-danger delete-btn" data-id="{{ $akun->akun_id }}" href="">Delete</a>
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

    $('.tambah-akun-btn').click(function(e){
        e.preventDefault();
        
        $.ajax({
            type: "get",
            url: "{{ url('modaltambahakun') }}",
            data: "data",
            dataType: "json",
            success: function (response) {
                console.log(response.modal)
                $('.modal_container').html(response.modal);
                var modalTambahAkun = new bootstrap.Modal(document.querySelector('.modal_container .tambah_akun'));
                modalTambahAkun.show();

            }
        });

    })

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
   

    $('table tbody').on('click','.delete-btn', function(e){
        e.preventDefault();
        let akun_id=$(this).data('id');
        console.log(akun_id);
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
                url: "{{ url('hapusakun') }}",
                data: {
                    akun_id
                },
                dataType: "json",
                success: function (response) {
                    console.log(response);
                $(location).attr('href','{{ url("akuns") }}')
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
</script>
@endsection