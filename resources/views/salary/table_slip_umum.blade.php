<h3>Daftar Gaji Umum bulan {{ $bulan }} {{ $tahun }}</h3>
<table class="table">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Bulan</th>
            <th>Tahun</th>
            <th>Total Gaji</th>
            <th>Total Potongan</th>
            <th>Sisa</th>
            <th>Aksi</th>

        </tr>
    </thead>
    <tbody>
        @foreach ($data as $d)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $d['nama'] }}</td>
            <td>{{ $d['bulan'] }}</td>
            <td>{{ $d['tahun'] }}</td>
            <td>{{ $d['total_gaji'] }}</td>
            <td>{{ $d['total_potongan'] }}</td>
            <td>{{ $d['sisa'] }}</td>
            <td><a href="{{ url('salary/get_slip/' . $bulan . '/' . $tahun.'/'.$d['nama'])  }}" class="btn btn-success"
                    target="_blank">Lihat Slip</a></td>
        </tr>

        @endforeach
    </tbody>
</table>