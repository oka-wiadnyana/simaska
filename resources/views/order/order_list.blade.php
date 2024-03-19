@extends('layout.main')

@section('content')
<div class="col bg-white shadow p-5">

    <h1>Daftar Pesanan</h1>

    <div class="row mb-2">
        <div class="col">
            <a href='{{ url("tambahpesanan") }}' class="btn btn-primary">Tambah Pesanan</a>
            @if(Session::get('employee_level')=='admin_umum'||Session::get('employee_level')=='kasubag_uk'||Session::get('employee_level')=='sekretaris'||Session::get('employee_level')=='wakil_ketua'||Session::get('employee_level')=='ketua')
            <button class="btn btn-info cetak-register">Cetak Register</button>
            <button class="btn btn-warning cetak-output">Cetak Barang Keluar</button>
            <a href='{{ url("anounce") }}' class="btn btn-success  anounce-btn">Umumkan WA</a>
            @endif

        </div>

    </div>
    <ul class="nav nav-tabs mb-2" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="terpenuhi-tab" data-bs-toggle="tab" data-bs-target="#home" type="button"
                role="tab" aria-controls="home" aria-selected="true">Terpenuhi</button>
        </li>
        <li class="nav-item " role="presentation">
            <button class="nav-link" id="half-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button"
                role="tab" aria-controls="profile" aria-selected="false">Sebagian</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="none-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button"
                role="tab" aria-controls="contact" aria-selected="false">Belum</button>
        </li>
    </ul>
    <table class="table table-bordered data-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Nomor Pesanan</th>
                <th>Tanggal Pesanan</th>
                <th>Bagian</th>
                <th>Nama</th>
                <th>Complete</th>
                @if(Session::get('employee_level')=='admin_umum'||Session::get('employee_level')=='kasubag_uk'||Session::get('employee_level')=='sekretaris'||Session::get('employee_level')=='wakil_ketua'||Session::get('employee_level')=='ketua')
                <th>Aksi</th>
                @endif

            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>
<div class="modal_container">

</div>




<script type="text/javascript">
    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var table = $('.data-table').DataTable({
          processing: true,
          serverSide: true,
          ajax: `{{ url('getordersdata') }}/terpenuhi`,
          columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
              {data: 'order_detail', name: 'order_detail'},
              {data: 'tanggal_pesanan', name: 'tanggal_pesanan'},
              {data: 'nama_unit', name: 'nama_unit'},
              {data: 'nama', name: 'nama'},
              {data: 'completed', name: 'completed'},
              @if(Session::get('employee_level')=='admin_umum'||Session::get('employee_level')=='kasubag_uk'||Session::get('employee_level')=='sekretaris'||Session::get('employee_level')=='wakil_ketua'||Session::get('employee_level')=='ketua')
            {data: 'action', name: 'action', orderable: false, searchable: false},
            @endif
          ],
          responsive:true
      });
        
    let getTableOrder=(jenis)=>{
        table = $('.data-table').DataTable({
          processing: true,
          serverSide: true,
          ajax: `{{ url('getordersdata') }}/${jenis}`,
          columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
              {data: 'order_detail', name: 'order_detail'},
              {data: 'tanggal_pesanan', name: 'tanggal_pesanan'},
              {data: 'nama_unit', name: 'nama_unit'},
              {data: 'nama', name: 'nama'},
              {data: 'completed', name: 'completed'},
              @if(Session::get('employee_level')=='admin_umum'||Session::get('employee_level')=='kasubag_uk'||Session::get('employee_level')=='sekretaris'||Session::get('employee_level')=='wakil_ketua'||Session::get('employee_level')=='ketua')
            {data: 'action', name: 'action', orderable: false, searchable: false},
            @endif
          ],
          responsive:true
      });
    }
      
    // getTableOrder('terpenuhi');
    //   new $.fn.dataTable.FixedHeader( table );

    $('#terpenuhi-tab').click(function(e){
        e.preventDefault();
        table.destroy();
        getTableOrder('terpenuhi');
    })

    $('#half-tab').click(function(e){
        e.preventDefault();
        table.destroy();
        getTableOrder('sebagian');
    })
        
    $('#none-tab').click(function(e){
        e.preventDefault();
        table.destroy();
        getTableOrder('none');
    })
   

   
    $('.cetak-register').click(function(e){
        e.preventDefault();
        
        $.ajax({
            type: "get",
            url: "{{ url('modalcetakregisterorder') }}",
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

    $('.cetak-output').click(function(e){
        e.preventDefault();
        
        $.ajax({
            type: "get",
            url: "{{ url('modalcetakoutput') }}",
            data: "data",
            dataType: "json",
            success: function (response) {
                console.log(response.modal)
                $('.modal_container').html(response.modal);
                var modalCetak = new bootstrap.Modal(document.querySelector('.modal_container .cetak_output'));
                modalCetak.show();

            }
        });

    })


    
    $('table tbody').on('click','.edit-btn', function(e){
        e.preventDefault();
        let order_id=$(this).data('id');
        console.log(order_id);
        $.ajax({
            type: "post",
            url: "{{ url('modaledittanggal') }}",
            data: {
                order_id
            },
            dataType: "json",
            success: function (response) {
                console.log(response);
                $('.modal_container').html(response.modal);
                        var modalEditTanggalOrder = new bootstrap.Modal(document.querySelector('.modal_container .edit_tanggal_order'));
                        modalEditTanggalOrder.show();
            }
        });
    })

    // $('table tbody').on('click','.order-detail-btn', function(e){
    //     e.preventDefault();
    //     let order_id=$(this).data('id');
    //     console.log(order_id);
    //     $.ajax({
    //         type: "post",
    //         url: "/modalorderdetail",
    //         data: {
    //             order_id
    //         },
    //         dataType: "json",
    //         success: function (response) {
    //             console.log(response);
    //             $('.modal_container').html(response.modal);
    //                     var modalOrderDetail = new bootstrap.Modal(document.querySelector('.modal_container .order_detail'));
    //                     modalOrderDetail.show();
    //         }
    //     });
    // })

    $('table tbody').on('click','.delete-btn', function(e){
                e.preventDefault();
                let order_id=$(this).data('id');
                console.log(order_id);
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
                    url: "{{ url('hapusorder') }}",
                    data: {
                        order_id
                    },
                    dataType: "json",
                    success: function (response) {
                        console.log(response);
                    $(location).attr('href','{{ url("orders") }}')
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
            url: "/modalupload",
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

    $('.anounce-btn').click(function(e){
        e.preventDefault();
        let btn=$(this);
        $.ajax({
            type: "get",
            url: "{{ url('anounce') }}",
            beforeSend:function(){
                btn.addClass('disabled');
            },
            dataType: "json",
            success: function (response) {
               if(response.msg==='success') {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: 'Pesan berhasil terkirim',
                })
               }else {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: 'Pesan gagal terkirim',
                })
               }
              btn.removeClass('disabled');

            }
        });

    })
});
    
</script>
@endsection