@extends('layout.main')

@section('content')

@push('thestyle')
@livewireStyles
@endpush
<div class="col bg-white shadow p-5">

    <h1>Hasil Review PPNPN</h1>
    <div class="row mb-2">
        <div class="col-md-6 d-flex">
            <button class="btn btn-primary tambah-penilaian-btn me-2">Tambah penilaian</button>
            <button class="btn btn-success cetak-bulanan-btn me-2">Cetak Penilaian</button>
         
        </div>

    </div>

    <table class="table table-bordered data-table" id="data-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Bulan</th>
                <th>Tahun</th>
                <th>Nama</th>
                <th>Integritas</th>
                <th>Kedisiplinan</th>
                <th>Kerjasama</th>
                <th>Komunikasi</th>
                <th>Pelayanan</th>
                <th>Evaluasi</th>
                @if (session('kepegawaian')==true)
                <th>Jumlah kehadiran</th>
                <th>Jumlah hari kerja</th>
                @endif
               
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
        
        var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                responsive:true,
                ajax: "{{ url('ppnpn/get_result_ppnpn_assessment') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                   
                    {
                        data: 'bulan',
                        name: 'bulan'
                    },
                    {
                        data: 'tahun',
                        name: 'tahun'
                    },
                    {
                        data: 'ppnpn_name',
                        name: 'ppnpn_name'
                    },
                    {
                        data: 'integritas',
                        name: 'integritas'
                    },
                    {
                        data: 'kedisiplinan',
                        name: 'kedisiplinan'
                    },
                    {
                        data: 'kerjasama',
                        name: 'kerjasama'
                    },
                    {
                        data: 'komunikasi',
                        name: 'komunikasi'
                    },
                    {
                        data: 'pelayanan',
                        name: 'pelayanan'
                    },
                    {
                        data: 'evaluasi',
                        name: 'evaluasi'
                    },
                  @if (session('kepegawaian')==true)
                      
                
                    {
                        data: 'jumlah_kehadiran',
                        name: 'jumlah_kehadiran'
                    },
                    {
                        data: 'jumlah_hari_kerja',
                        name: 'jumlah_hari_kerja'
                    },
                   
                    @endif
                ]
            });
    //   new $.fn.dataTable.FixedHeader( table );
        
    });

    

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


    $('.tambah-penilaian-btn').click(function(e){
        e.preventDefault();
        
        $.ajax({
            type: "get",
            url: "{{ url('ppnpn/modal_tambah_penilaian') }}",
           
            dataType: "json",
            success: function (response) {
                console.log(response.modal)
                $('.modal_container').html(response.modal);
                var modal = new bootstrap.Modal(document.querySelector('.modal_container .tambah_penilaian'));
                modal.show();

            }
        });

    })
    $('.cetak-bulanan-btn').click(function(e){
        e.preventDefault();
        
        $.ajax({
            type: "get",
            url: "{{ url('ppnpn/modal_cetak_review_bulanan') }}",
           
            dataType: "json",
            success: function (response) {
                console.log(response.modal)
                $('.modal_container').html(response.modal);
                var modalCetakBulanan = new bootstrap.Modal(document.querySelector('.modal_container .cetak_review_bulanan'));
                modalCetakBulanan.show();

            }
        });

    })

    $('.cetak-harian-btn').click(function(e){
        e.preventDefault();
        
        $.ajax({
            type: "get",
            url: "{{ url('modal_cetak_review_harian_ptsp') }}",
           
            dataType: "json",
            success: function (response) {
                console.log(response.modal)
                $('.modal_container').html(response.modal);
                var modalCetak = new bootstrap.Modal(document.querySelector('.modal_container .cetak_review_harian'));
                modalCetak.show();

            }
        });

    })

   

  

  
</script>
@endsection