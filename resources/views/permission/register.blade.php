<!DOCTYPE html>
<html>

<head>
    <title>Register Surat</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <style>
        * {
            font-family: Arial, Helvetica, sans-serif;
        }
    </style>
</head>

<body>
    <div class="row">
        <div class="div text-center">
            <p style="font-size: 2rem">Register Izin Keluar Kantor</p>
        </div>
        <div class="div text-center">
            @if(isset($bulan))
            <p style="font-size: 1rem">Bulan {{ $bulan }} {{ $tahun }}</p>
            @else
            <p style="font-size: 1rem">Tahun {{ $tahun }}</p>
            @endif
        </div>
    </div>

    <table class="table table-bordered">
        <tr>
            <th>No</th>

            <th>Pegawai</th>
            <th>Tanggal</th>
            <th>Pukul</th>
            <th>Alasan</th>

        </tr>
        @php
        $no=1;
        @endphp
        @foreach($data as $d)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $d->nama }}</td>
            <td>{{ $d->tanggal }}</td>

            <td>{{ $d->jam_awal . ' s.d ' . $d->jam_akhir; }}</td>
            <td>{{ $d->alasan }}</td>

        </tr>
        @endforeach
    </table>
</body>

</html>