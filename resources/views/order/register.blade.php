<!DOCTYPE html>
<html>

<head>
    <title>Register Order </title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <style>
        * {
            font-family: Arial, Helvetica, sans-serif;
        }

        @page {
            size: auto;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="div">
                <span style="font-size: 2rem">Register Order</span>
            </div>
        </div>
        <div class="row d-flex justify-content-center mb-3">
            {{-- <div class="div text-center"> --}}

                @if(isset($bulan))
                <span style="font-size: 1rem">Bulan {{ $bulan }} {{ $tahun }}</span>
                @else
                <span style="font-size: 1rem">Tahun {{ $tahun }}</span>
                @endif
                {{--
            </div> --}}
        </div>

        <table class="table table-bordered">
            <tr>
                <th>No</th>
                <th>Nomor Pesanan</th>
                <th>Tanggal Pesanan</th>
                <th>Barang</th>
                <th>Complete</th>
                <th>Nama Pemesan</th>
                <th>Unit</th>
                <th>Keterangan</th>
            </tr>
            @php
            $no=1;
            @endphp
            @foreach($orders as $key=>$value)
            @php
            $complete=$value->pluck('complete')->filter();
            @endphp
            @foreach ($value as $v )
            <tr>
                @if ($loop->first)

                <td rowspan="{{ $value->count() }}">{{ $no++ }}</td>
                <td rowspan="{{ $value->count() }}">{{ $key }}</td>
                <td rowspan="{{ $value->count() }}">{{ $value[0]->tanggal_pesanan }}</td>
                @endif

                <td>{{ $v->nama_barang }}</td>
                <td>{{ $v->complete }}</td>
                @if ($loop->first)

                <td rowspan="{{ $value->count() }}">{{ $value[0]->nama }}</td>
                <td rowspan="{{ $value->count() }}">{{ $value[0]->nama_unit }}</td>
                <td rowspan="{{ $value->count() }}">{{ $value->count()==count($complete)?'Terpenuhi':(count($complete) >
                    0
                    ?'Sebagian
                    terpenuhi':'Belum terpenuhi') }}</td>
                @endif

            </tr>
            @endforeach




            @endforeach
        </table>
    </div>

</body>

</html>