@extends('layout.main')

@section('content')
<div class="col bg-white shadow p-5">

    <h1>Daftar Pegawai</h1>
    <div class="row mb-2">
        <div class="col">
            <button class="btn btn-primary tambah-pegawai-btn">Tambah Pegawai</button>
        </div>
    </div>
    <table class="table table-bordered data-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>NIP</th>
                <th>Jabatan</th>
                <th>Bagian</th>
                <th>Pangkat/Golongan</th>
                <th>Atasan Langsung</th>
                <th>No HP</th>
                <th>Masa Kerja</th>
                <th>Potongan MK</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @php
            $no=1;
            @endphp
            @foreach ( $employees as $employee )
            <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $employee['nama'] }}</td>
                <td>{{ $employee['nip'] }}</td>
                <td>{{ $employee['nama_jabatan'] }}</td>
                <td>{{ $employee['nama_unit'] }}</td>
                <td>{{ $employee['pangkat'].'/'.$employee['golongan_pegawai'] }}</td>
                <td>{{ $employee['is_atasan_langsung'] }}</td>
                <td>{{ $employee['nomor_hp'] }}</td>
                <td>{{ $employee['masa_kerja'] }}</td>
                <td>{{ $employee['potongan_mk'] }}</td>

                <td><a class="btn btn-warning update-btn" data-id="{{ $employee['id_pegawai'] }}" href="">Update</a>
                    <a class="btn btn-danger delete-btn" data-id="{{ $employee['id_pegawai'] }}" href="">Delete</a>
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

    $('.tambah-pegawai-btn').click(function(e){
        e.preventDefault();
        
        $.ajax({
            type: "get",
            url: "{{ url('modaltambahpegawai') }}",
            data: "data",
            dataType: "json",
            success: function (response) {
                console.log(response.modal)
                $('.modal_container').html(response.modal);
                var modalTambahPegawai = new bootstrap.Modal(document.querySelector('.modal_container .tambah_pegawai'));
                modalTambahPegawai.show();

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
        let id_pegawai=$(this).data('id');

        $.ajax({
            type: "post",
            url: "{{ url('modaleditpegawai') }}",
            data: {
                id_pegawai
            },
            dataType: "json",
            success: function (response) {
                console.log(response);
                $('.modal_container').html(response.modal);
                        var modalEditPegawai = new bootstrap.Modal(document.querySelector('.modal_container .edit_pegawai'));
                        modalEditPegawai.show();
            }
        });
    })

    $('table tbody').on('click','.delete-btn', function(e){
        e.preventDefault();
        let id_pegawai=$(this).data('id');
        console.log(id_pegawai);
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
                url: "{{ url('hapuspegawai') }}",
                data: {
                    id_pegawai
                },
                dataType: "json",
                success: function (response) {
                    console.log(response);
                $(location).attr('href','{{ url("employees") }}')
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