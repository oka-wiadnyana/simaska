<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Sisa Cuti</title>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="row text-center"><span class="fw-bold fs-3">Rekap Sisa Cuti</span></div>
                <div class="row text-center"><span class="fw-bold fs-3">Tahun {{ $tahun }}</span></div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <td>No</td>
                            <td>Nama</td>
                            <td>Jml cuti tahun ini</td>
                            <td>Sisa cuti tahun lalu</td>
                            <td>Penangguhan tahun lalu</td>
                            <td>Dipakai tahun ini</td>
                            <td>Sisa</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $d)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $d['nama'] }}</td>
                            <td>{{ $d['saldo_cuti_tahun_ini']??0 }}</td>
                            <td>{{ $d['sisa_cuti_tahun_lalu']??0 }}</td>
                            <td>{{ $d['penangguhan_tahun_lalu']??0 }}</td>
                            <td>{{ $d['penggunaan_tahun_ini']??0 }}</td>
                            <td>{{ $d['sisa_cuti_tahun_ini']??0 }}</td>
                        </tr>

                        @endforeach
                    </tbody>

                </table>
            </div>
        </div>

    </div>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->
</body>

</html>