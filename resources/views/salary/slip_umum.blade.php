@extends('layout.main')

@section('content')
<div class="col bg-white shadow p-5 ">
    <div class="row mb-3">
        <div class="col">
            <select name="bulan_search" id="" class="form-control">

                <option value="" selected disabled>Pilih Bulan</option>
                @for ($i=1;$i<=12;$i++) <option value="{{ $i }}">{{
                    Illuminate\Support\Carbon::parse(date('Y').'-'.$i.'-01')->isoFormat('MMMM') }}</option>
                    @endfor
            </select>
        </div>
        <div class="col">
            <select name="tahun_search" id="" class="form-control">
                <option value="" selected disabled>Pilih Tahun</option>
                @for ($i=0;$i<10;$i++) <option value="{{ date('Y')-$i }}">{{ date('Y')-$i }}</option>
                    @endfor
            </select>
        </div>
        <div class="col">
            <button class="btn btn-info search_btn">Cari</button>
        </div>
    </div>
    <div class="row slip-container">

    </div>

</div>





<script type="text/javascript">
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        let getData = (bulan = null, tahun = null) => {
            $.ajax({
                type: "post",
                url: "{{ url('getsalaryumum') }}",
                data: {
                    bulan,
                    tahun
                },
                dataType: "json",
                success: function(response) {
                    $('.slip-container').html("");
                    $('.slip-container').html(response);
                }
            });
        }

        getData();

        $('.search_btn').click(function (e) { 
            let bulan=$('[name="bulan_search"]').val();
            let tahun=$('[name="tahun_search"]').val();
            getData(bulan,tahun);
         })



    });
</script>
@endsection