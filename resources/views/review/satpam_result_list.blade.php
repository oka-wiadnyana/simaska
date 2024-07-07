@extends('layout.main')

@section('content')
    @push('thestyle')
        @livewireStyles
    @endpush
    <div class="col bg-white shadow p-5">

        <h1>Hasil Review Petugas Satpam</h1>
        <div class="row mb-2">
            <div class="col-md-6 d-flex">
                <button class="btn btn-primary cetak-bulanan-btn me-2">Cetak Lap Bulanan</button>
                <button class="btn btn-success cetak-harian-btn">Cetak Rekap Harian</button>


            </div>

        </div>

        <table class="table table-bordered data-table" id="data-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Nama</th>
                    <th>NIP</th>

                    <th>Integritas</th>
                    <th>Komunikasi</th>
                    <th>Kompetensi</th>
                    <th>Evaluasi</th>

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
        $(function() {

            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: "{{ url('review/get_result_satpam') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },

                    {
                        data: 'assessment_date',
                        name: 'assessment_date'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'nip',
                        name: 'nip'
                    },

                    {
                        data: 'result',
                        name: 'result'
                    },
                    {
                        data: 'result_komunikasi',
                        name: 'result_komunikasi'
                    },
                    {
                        data: 'result_kompetensi',
                        name: 'result_kompetensi'
                    },
                    {
                        data: 'evaluation',
                        name: 'evaluation'
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


        $('.cetak-bulanan-btn').click(function(e) {
            e.preventDefault();

            $.ajax({
                type: "get",
                url: "{{ url('modal_cetak_review_bulanan_satpam') }}",

                dataType: "json",
                success: function(response) {
                    console.log(response.modal)
                    $('.modal_container').html(response.modal);
                    var modalCetakBulanan = new bootstrap.Modal(document.querySelector(
                        '.modal_container .cetak_review_bulanan'));
                    modalCetakBulanan.show();

                }
            });

        })

        $('.cetak-harian-btn').click(function(e) {
            e.preventDefault();

            $.ajax({
                type: "get",
                url: "{{ url('modal_cetak_review_harian_satpam') }}",

                dataType: "json",
                success: function(response) {
                    console.log(response.modal)
                    $('.modal_container').html(response.modal);
                    var modalCetak = new bootstrap.Modal(document.querySelector(
                        '.modal_container .cetak_review_harian'));
                    modalCetak.show();

                }
            });

        })
    </script>
@endsection
