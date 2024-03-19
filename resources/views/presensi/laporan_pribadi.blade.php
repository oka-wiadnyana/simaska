@extends('layout.main')

@section('content')
<div class="col bg-white shadow p-5">

    <h1>Laporan Presensi Pribadi </h1>

    <div class="row mb-2">
        <div class="col-md-6 d-flex">
            <div class="col form-group p-1">
                <select name="bulan-search" id="" class="form-control cari-bulan">
                    <option value="" selected disabled>Pilih</option>
                    @foreach ($bulans as $bulan)
                    <option value="{{ $bulan['month_number'] }}">{{ $bulan['month_name'] }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col form-group p-1">
                <select name="tahun-search" id="" class="form-control cari-tahun">
                    <option value="" selected disabled>Pilih</option>
                    @foreach ($tahuns as $tahun)
                    <option value="{{ $tahun }}">{{ $tahun }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col">
                <button class="btn btn-info cari-btn">Cari</button>
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
        function getTablePresensi(bulan=null,tahun=null) {
            $.ajax({
                type: "post",
                url: "{{ url('presensi/get_table_pribadi') }}",
                data: {
                    bulan,
                    tahun
                },
                dataType: "json",
                success: function (response) {
                    $('.table-container').html(response);
                }
            });
        }
    
    getTablePresensi();

    $('.cari-btn').attr('disabled',true);
    $('.cari-tahun').change(function(){
        $('.cari-btn').attr('disabled',false);
    })
    $('.cari-btn').click(function(e){
        e.preventDefault();

        let bulan= $('.cari-bulan').val();
        let tahun= $('.cari-tahun').val();
        console.log(bulan,tahun)
        $('.table-container').html("");
        getTablePresensi(bulan,tahun);
    })

    
    });
</script>
@endsection