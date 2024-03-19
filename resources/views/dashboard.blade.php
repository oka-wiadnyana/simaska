@extends('layout.main')

@section('content')
<div class="col bg-white shadow p-5">
    <div class="row mt-3 shadow justify-content-center p-3 rounded-3">
        <div class="row text-center">

            <div class="col mb-2"><span class="h3">Cuti Aktif</span></div>
        </div>
        <div class="row table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Tgl Awal</th>
                        <th>Tgl Akhir</th>
                        <th>Jenis Cuti</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cuti_aktif as $cuti)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $cuti->nama }}</td>
                        <td>{{ $cuti->tgl_mulai }}</td>
                        <td>{{ $cuti->tgl_akhir }}</td>
                        <td>{{ $cuti->jenis }}</td>
                    </tr>

                    @endforeach
                </tbody>
            </table>
        </div>
        @if (session('employee_level')!='ketua')
        <div class="row">
            <div class="d-md-flex p-0">
                <div class="col p-1">
                    <div class="card">
                        <div class="card-header">
                            Saldo tahun ini
                        </div>
                        <div class="card-body overflow-hidden position-relative">
                            <span class="fs-1 fw-bold">{{ $saldo_cuti->saldo_cuti_tahun_ini??0 }}</span>
                            <i class='bx bx-landscape position-absolute display-1 bottom-0 text-primary'
                                style="right:-15px"></i>
                        </div>
                    </div>
                </div>
                <div class="col p-1">
                    <div class="card">
                        <div class="card-header">
                            Sisa tahun lalu
                        </div>
                        <div class="card-body overflow-hidden position-relative">
                            <span class="fs-1 fw-bold">{{ $saldo_cuti->sisa_cuti_tahun_lalu??0 }}</span>
                            <i class='bx bx-pie-chart-alt-2 position-absolute display-1 bottom-0 text-success'
                                style="right:-15px"></i>
                        </div>
                    </div>
                </div>
                <div class="col p-1">
                    <div class="card">
                        <div class="card-header">
                            Penangguhan th. lalu
                        </div>
                        <div class="card-body overflow-hidden position-relative">
                            <span class="fs-1 fw-bold">{{ $saldo_cuti->penangguhan_tahun_lalu??0 }}</span>
                            <i class='bx bx-archive position-absolute display-1 bottom-0 text-warning'
                                style="right:-15px"></i>
                        </div>
                    </div>
                </div>
                <div class="col p-1">
                    <div class="card">
                        <div class="card-header">
                            Penggunaan th. ini
                        </div>
                        <div class="card-body overflow-hidden position-relative">
                            <span class="fs-1 fw-bold">{{ $penggunaan??0 }}</span>
                            <i class='bx bx-directions position-absolute display-1 bottom-0 text-info'
                                style="right:-15px"></i>
                        </div>
                    </div>
                </div>
                <div class="col p-1">
                    <div class="card">
                        <div class="card-header">
                            Sisa tahun ini
                        </div>
                        <div class="card-body overflow-hidden position-relative">
                            <span class="fs-1 fw-bold">{{ $sisa??0 }}</span>
                            <i class='bx bx-train position-absolute display-1 bottom-0 text-danger'
                                style="right:-15px"></i>
                        </div>
                    </div>
                </div>

            </div>


        </div>
        @endif

    </div>
    <div class="row mt-2 m">
        <div class="col d-flex justify-content-center">
            <div class="col-3">

                <select name="" id="select-tahun" class="form-control">
                    <option value="" selected disabled>Pilih tahun</option>
                    @php
                    $tahun = date('Y');
                    @endphp
                    @for ($i = 0; $i < 10; $i++) <option value="{{ $tahun - $i; }}">{{ $tahun - $i; }}</option>
                        @endfor

                </select>
            </div>
        </div>
    </div>
    <div class="container-fluid dashboard-wrapper shadow rounded-3 mt-3">

        <div class="row my-2">
            <div class="col">
                <div class="bg-white p-3 rounded">
                    <canvas id="myChart"></canvas>
                </div>
            </div>
            {{-- <div class="col-md-6">
                <div class="bg-white p-3 rounded">
                    <canvas id="myChart2"></canvas>
                </div>
            </div> --}}
        </div>
    </div>


    <div class="modal_container">

    </div>
</div>




<script type="text/javascript">
    $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
        });
            let myChart;
            let myChart2;

            let data_chart = (tahun = null) => {
                let tahun_send;
                if (tahun == null) {
                    tahun_send = new Date().getFullYear();
                } else {
                    tahun_send = tahun;
                }
                $.ajax({
                    type: "post",
                    url: "{{ url('getchartsurat') }}",
                    data: {
                        tahun_send
                    },
                    dataType: "json",
                    success: function(response) {
                        console.log(response)
                        const labels = [
                            'January',
                            'February',
                            'March',
                            'April',
                            'May',
                            'June',
                            'Juli',
                            'Agustus',
                            'September',
                            'Oktober',
                            'Nopember',
                            'Desember'
                        ];



                        myChart = new Chart(
                            document.getElementById('myChart'), {
                                type: 'bar',
                                data: {
                                    labels: labels,
                                    datasets: [{
                                        label: 'Jml Surat',
                                        data: response,
                                        backgroundColor: [
                                            'rgba(255, 99, 132, 0.2)',
                                            'rgba(255, 99, 132, 0.2)',
                                            'rgba(255, 99, 132, 0.2)',
                                            'rgba(255, 99, 132, 0.2)',
                                            'rgba(255, 99, 132, 0.2)',
                                            'rgba(255, 99, 132, 0.2)',
                                            'rgba(255, 99, 132, 0.2)',
                                            'rgba(255, 99, 132, 0.2)',
                                            'rgba(255, 99, 132, 0.2)',
                                            'rgba(255, 99, 132, 0.2)',
                                            'rgba(255, 99, 132, 0.2)',
                                            'rgba(255, 99, 132, 0.2)',

                                        ],
                                        borderColor: [
                                            'rgb(255, 99, 132)',
                                            'rgb(255, 159, 64)',
                                            'rgb(255, 205, 86)',
                                            'rgb(75, 192, 192)',
                                            'rgb(54, 162, 235)',
                                            'rgb(153, 102, 255)',
                                            'rgb(201, 203, 207)',
                                            'rgb(201, 203, 207)',
                                            'rgb(201, 203, 207)',
                                            'rgb(201, 203, 207)',
                                            'rgb(201, 203, 207)',
                                            'rgb(201, 203, 207)',
                                        ],
                                        borderWidth: 1
                                    }]
                                },

                            }

                        );

                    }
                });
            }

           
            data_chart();
          

            $('#select-tahun').change(() => {
                let tahun = $('#select-tahun').val();
                console.log(tahun);
                myChart.destroy();
                // myChart2.destroy();


                data_chart(tahun);
                // data_chart2(tahun);

            })
        });
</script>
@endsection