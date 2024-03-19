<table class="table">
    <thead>
        <tr>
            <th>No</th>

            <th>Tanggal</th>
            <th>Pukul</th>
            <th>Lokasi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $d)
        <tr>

            <td>{{ $loop->iteration }}</td>

            <td>{{ $d->tanggal }}</td>
            <td>{{ $d->pukul }}</td>
            <td><a href="http://maps.google.com/maps?z=12&t=m&q=loc:{{ $d->latitude }}+{{ $d->longitude }}"
                    class="btn btn-small btn-info" target="_blank">Lihat</a></td>
        </tr>
        @endforeach
    </tbody>
</table>