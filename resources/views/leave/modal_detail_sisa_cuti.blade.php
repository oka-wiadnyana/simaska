<div class="modal modal_detail" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail sisa cuti</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <table class="table data-table-sisa-cuti table-bordered">
                    <thead>

                        <tr>
                            <th>Tahun</th>
                            <th>Cuti tahun ini</th>
                            <th>Sisa tahun lalu</th>
                            <th>Penangguhan tahun lalu</th>
                            <th>Penggunaan tahun ini</th>
                            <th>Sisa tahun ini</th>
                            <th>Aksi</th>
                        </tr>

                    </thead>
                    <tbody>
                        @foreach ($data_cuti as $d)

                        <tr>
                            <td>{{ $d['tahun'] }}</td>
                            <td>{{ $d['saldo_cuti_tahun_ini']??0 }}</td>
                            <td>{{ $d['sisa_cuti_tahun_lalu']??0 }}</td>
                            <td>{{ $d['penangguhan_tahun_lalu']??0 }}</td>
                            <td>{{ $d['penggunaan_tahun_ini'] }}</td>
                            <td>{{ $d['sisa_cuti_tahun_ini'] }}</td>
                            <td><a href="" class="btn btn-warning edit-btn" data-tahun={{ $d['tahun'] }} data-nip={{
                                    $d['nip'] }}>Edit</a></td>
                        </tr>

                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
     

      $('.data-table-sisa-cuti').DataTable({
        responsive:true
      });

     
    });
</script>