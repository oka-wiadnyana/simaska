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
            <p style="font-size: 2rem">Register Surat Keluar</p>
           
            <p style="font-size: 1.5rem">{{ $signer=='kpt'?'Ketua Pengadilan Tinggi':($signer=='pan'?'Panitera':'Sekretarus') }}</p>
        </div>
        <div class="div text-center">
            
            <p style="font-size: 1rem">Tanggal {{ \Illuminate\Support\Carbon::parse($tanggal)->format('d-m-Y') }}</p>
           
        </div>
    </div>

    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>Nomor surat</th>
            <th>Tanggal surat</th>
            <th>Perihal</th>
            <th>Tujuan</th>
            <th>Nama Pemohon</th>
            <th>Bagian</th>
        </tr>
        @php
        $no=1;
        @endphp
        @foreach($surat as $s)
        <tr>
            <td>{{ $no++ }}</td>
            <td>{{ $s->nomor_surat }}</td>
            <td>{{ $s->tanggal_surat }}</td>
            <td>{{ $s->perihal }}</td>
            <td>{{ $s->tujuan }}</td>
            <td>{{ $s->nama }}</td>
            <td>{{ $s->bagian }}</td>
        </tr>
        @endforeach
    </table>
</body>

</html>