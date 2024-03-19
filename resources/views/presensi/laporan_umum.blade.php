@extends('layout.main')

@section('content')
<div class="col bg-white shadow p-5">

    <h1>Laporan Presensi Umum </h1>

    <div class="row mb-2">
        <div class="col">
            <form action="{{ url('presensi/cetak_laporan_umum') }}" method="post" target="_blank" class="d-flex">
                @csrf
                <div class="col-md-3 form-group p-1">
                    <input type="date" class="form-control cari-tanggal" name="tanggal">

                </div>

                <div class="col">
                    <button class="btn btn-info cari-btn">Cari</button>
                    <button class="btn btn-success" type="submit">Cetak</button>
                </div>
            </form>
            <div class="col">

            </div>

        </div>


    </div>
    <div class="row">
        <div class="col table-container">

        </div>
    </div>
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
        function getTablePresensi(tanggal=null) {
            $.ajax({
                type: "post",
                url: "{{ url('presensi/get_table_umum') }}",
                data: {
                    tanggal
                },
                dataType: "json",
                success: function (response) {
                    $('.table-container').html(response);
                }
            });
        }
    
    getTablePresensi();

    $('.cari-btn').attr('disabled',true);
    $('.cari-tanggal').change(function(){
        $('.cari-btn').attr('disabled',false);
    })
    $('.cari-btn').click(function(e){
        e.preventDefault();
        let tanggal= $('.cari-tanggal').val();
        $('.table-container').html("");
        getTablePresensi(tanggal);
    })

    
    });
</script>
@endsection