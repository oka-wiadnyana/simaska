@extends('layout.main')

@section('content')
<div class="col bg-white shadow p-5">

    <h1>Daftar Permohonan</h1>
    {{-- <div class="row mb-2">
        <div class="col">
            <button class="btn btn-primary tambah-btn">Tambah Cuti</button>
            @if(Session::get('employee_level')=='admin_ortala'||Session::get('employee_level')=='kasubag_ortala'||Session::get('employee_level')=='sekretaris'||Session::get('employee_level')=='wakil_ketua'||Session::get('employee_level')=='ketua')
            <button class="btn btn-success cetak-register">Cetak</button>
            @endif
        </div>

    </div> --}}
    <table class="table table-bordered data-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode</th>
                <th>Tgl Pengajuan</th>
                <th>Jenis Cuti</th>
                <th>Pegawai</th>
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
    $(function () {
        
      var table = $('.data-table').DataTable({
          processing: true,
          serverSide: true,
          ajax: "{{ route('getleavespermohonan',['jenis'=>$jenis]) }}",
          columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
              {data: 'kode_cuti', name: 'kode_cuti'},
              {data: 'tgl_pengajuan', name: 'tgl_pengajuan'},
              {data: 'jenis', name: 'jenis'},
              {data: 'nama', name: 'nama'},
              {data: 'tgl_mulai', name: 'tgl_mulai'},
              {data: 'tgl_akhir', name: 'tgl_akhir'},
              {data: 'hari_efektif', name: 'hari_efektif'},
              {data: 'status', name: 'status'},           
              {data: 'action', name: 'action', orderable: false, searchable: false},
          ],
          responsive:true
      });
    //   new $.fn.dataTable.FixedHeader( table );
        
    });

    $('.tambah-btn').click(function(e){
        e.preventDefault();
        
        $.ajax({
            type: "get",
            url: "{{ route('modalinsertgeneral') }}",
            data: "data",
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
            url: "{{ url('modalcetakregister') }}",
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
    $('table tbody').on('click','.setuju-btn', function(e){
        e.preventDefault();
        let id_leave=$(this).data('id');
        console.log(id_leave);
        Swal.fire({
            title: 'Apakah yakin menyetujuinya?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, setujui!',
            cancelButtonText:'Batal'
            }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                type: "post",
                url: "{{ url('leave/setujuatasan') }}",
                data: {
                    id_leave
                },
                dataType: "json",
                success: function (response) {
                    console.log(response);
                $(location).attr('href','{{ url("leave/permohonan/".$jenis) }}')
                }
            });
            }
            })

    })

    $('table tbody').on('click','.tolak-btn', function(e){
        e.preventDefault();
        let id_leave=$(this).data('id');
        console.log(id_leave);
        $.ajax({
            type: "post",
            url: "{{ url('leave/modaltolakatasan') }}",
            data: {
                id_leave
            },
            dataType: "json",
            success: function (response) {
                console.log(response.modal)
                $('.modal_container').html(response.modal);
                var modaltolak = new bootstrap.Modal(document.querySelector('.modal_container .tolak_atasan'));
                modaltolak.show();

            }
        });

    })
    $('table tbody').on('click','.tangguhkan-btn', function(e){
        e.preventDefault();
        let id_leave=$(this).data('id');
        console.log(id_leave);
        $.ajax({
            type: "post",
            url: "{{ url('leave/modaltangguhkanatasan') }}",
            data: {
                id_leave
            },
            dataType: "json",
            success: function (response) {
                console.log(response.modal)
                $('.modal_container').html(response.modal);
                var modaltolak = new bootstrap.Modal(document.querySelector('.modal_container .tangguhkan_atasan'));
                modaltolak.show();

            }
        });

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