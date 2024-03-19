<!DOCTYPE html>
<html>

<head>
    <title>Register Presensi Umum </title>
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
    <div class="">
        <div class="row text-center">
            <div class="div">
                <span style="font-size: 2rem">Register Presensi</span>
            </div>
        </div>
        <div class="row text-center mb-3">
            <span style="font-size: 1rem">Tanggal {{ $data[0]->tanggal }}</span>
        </div>

        <table class="table table-bordered">
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Pukul</th>
                <th>Latitude</th>
                <th>Longitude</th>

            </tr>

            @foreach ($data as $d )
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $d->nama }}</td>
                <td>{{ $d->pukul }}</td>
                <td>{{ $d->latitude }}</td>
                <td>{{ $d->longitude }}</td>

            </tr>
            @endforeach


        </table>
    </div>

</body>

</html>