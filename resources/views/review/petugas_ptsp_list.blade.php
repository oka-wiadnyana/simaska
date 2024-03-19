@extends('layout.main')

@section('content')

@push('thestyle')
@livewireStyles
@endpush
<div class="col bg-white shadow p-5">

    <h1>Petugas PTSP</h1>
    <div class="row mb-2">
        <div class="col-md-6 d-flex">
            <button class="btn btn-primary add-petugas-ptsp">Tambah petugas</button>
         
         
        </div>

    </div>

    <table class="table table-bordered data-table" id="data-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Nama Pendek</th>
                <th>NIP</th>
                <th>Unit</th>
                <th>Jabatan</th>
                <th>Aktif</th>
                <th>Aksi</th>
               
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>



@push('thescript')
@livewireScripts
@endpush
<div class="modal_container">

</div>
<script type="text/javascript">
    $(function () {
        
        var table = $('.table').DataTable({
                processing: true,
                serverSide: true,
                responsive:true,
                ajax: "{{ url('review/get_petugas_ptsp') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                   
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'nick_name',
                        name: 'nick_name'
                    },
                    {
                        data: 'nip',
                        name: 'nip'
                    },
                    {
                        data: 'unit_name',
                        name: 'unit_name'
                    },
                    {
                        data: 'department',
                        name: 'department'
                    },
                    {
                        data: 'active',
                        name: 'active'
                    },
                    
                    {
                        data: 'action',
                        name: 'action',
                        orderable: true,
                        searchable: true
                    },
                ]
            });
    //   new $.fn.dataTable.FixedHeader( table );
        
    });

    

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


    $('.add-petugas-ptsp').click(function(e){
        e.preventDefault();
        
        $.ajax({
            type: "get",
            url: "{{ url('review/modal_tambah_petugas_ptsp') }}",
           
            dataType: "json",
            success: function (response) {
                console.log(response.modal)
                $('.modal_container').html(response.modal);
                var modalPetugasPtsp = new bootstrap.Modal(document.querySelector('.modal_container .tambah_petugas_ptsp'));
                modalPetugasPtsp.show();

            }
        });

    })

    function deleteData(route,id,message='Yakin dihapus?'){
    Swal.fire({
        title: message,
        showDenyButton: true,
        showCancelButton: true,
        confirmButtonText: "Yakin",
        denyButtonText: `Tidak`
        }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed) {
            axios.post(route, {
                id,
            })
            .then(function (response) {
               location.reload();
            })
            .catch(function (error) {
                console.log(error);
            });
        } else if (result.isDenied) {
            Swal.fire("Cancel", "", "info");
        }
    });
}

$('table tbody').on('click','.update-btn', function(e){
        e.preventDefault();
        let id_pegawai=$(this).data('id');
        console.log(id_pegawai)

        $.ajax({
            type: "post",
            url: "{{ url('review/modal_edit_ptsp') }}",
            data: {
                id_pegawai
            },
            dataType: "json",
            success: function (response) {
                console.log(response);
                $('.modal_container').html(response.modal);
                        var modalEdit = new bootstrap.Modal(document.querySelector('.modal_container .edit_pegawai'));
                        modalEdit.show();
            }
        });
    })

    

   

  

  
</script>
@endsection