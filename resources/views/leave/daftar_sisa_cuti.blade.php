@extends('layout.main')

@section('content')
<div class="col bg-white shadow p-5">

    <h1>Daftar Sisa Cuti Tahunan Pegawai</h1>
    <div class="row mb-2">
        <form action="{{ url('leave/cetakrekapsaldocuti') }}" method="post" target="_blank" class="m-0 p-0">
            @csrf
            <div class="col-md-4 d-md-flex gap-2">

                <select name="tahun_select" id="" class="form-control">
                    <option value="" selected disabled>Tahun</option>
                    @foreach ($tahuns as $tahun)
                    <option value="{{ $tahun }}" @selected($tahun==date('Y'))>{{ $tahun }}</option>
                    @endforeach
                </select>


                <button class="btn btn-info" type="submit">Cetak rekap</button>


            </div>
        </form>


    </div>
    <table class="table table-bordered data-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>NIP</th>

                <th>Aksi</th>

            </tr>
        </thead>
        <tbody>
            @foreach ($pegawai as $p)
            @if ($p->nip&&$p->nip!="-")
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $p->nama }}</td>
                <td>{{ $p->nip }}</td>
                <td><a href="" class="btn btn-success detail-btn" data-nip={{ $p->nip }}>Detail</a> <a href=""
                        class="btn btn-info tambah-btn" data-nip={{ $p->nip }}>Tambah</a></td>
            </tr>
            @endif


            @endforeach
        </tbody>
    </table>
</div>
<div class="modal_container">

</div>




<script type="text/javascript">
    $('.modal_container').on('hidden.bs.modal', function () {
  $('.modal-detail-sisa-cuti').dataTable().fnDestroy();
 
});
    $(function () {
        
      var table = $('.data-table').DataTable({
        //   processing: true,
        //   serverSide: true,
        //   ajax: urlDatatable,
          
          responsive:true
      });
    //   new $.fn.dataTable.FixedHeader( table );
    
    });

    $('.tambah-btn').click(function(e){
        e.preventDefault();
        let nip=$(this).data('nip');
        $.ajax({
            type: "get",
            url: `{{ url('leave/tambah_saldo_cuti?') }}nip=${nip}`,
            data: "data",
            dataType: "json",
            success: function (response) {
                console.log(response.modal)
                $('.modal_container').html(response.modal);
                var modalDetail = new bootstrap.Modal(document.querySelector('.modal_container .modal_saldo'));
                modalDetail.show();
            }
        });

    })

    $('.detail-btn').click(function(e){
        e.preventDefault();
        let nip=$(this).data('nip');
        $.ajax({
            type: "get",
            url: `{{ url('leave/detail_sisa_cuti?') }}nip=${nip}`,
            data: "data",
            dataType: "json",
            success: function (response) {
                console.log(response.modal)
                $('.modal_container').html(response.modal);
                var modalDetail = new bootstrap.Modal(document.querySelector('.modal_container .modal_detail'));
                modalDetail.show();
            }
        });

    })


    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    



    $('.modal_container').on('click','.edit-btn', (function (e) { 
        e.preventDefault();
        let nip=$(this).data('nip');
        let tahun=$(this).data('tahun');
        $('.modal_detail').modal('hide');
        $.ajax({
            type: "get",
            url: `{{ url('leave/edit_sisa_cuti?') }}nip=${nip}&tahun=${tahun}`,
            data: "data",
            dataType: "json",
            success: function (response) {
                console.log(response.modal)
                $('.modal_container').html(response.modal);
                var modalDetail = new bootstrap.Modal(document.querySelector('.modal_container .modal_edit_sisa_cuti'));
                modalDetail.show();
            }
        });

    }))

    
</script>
@endsection