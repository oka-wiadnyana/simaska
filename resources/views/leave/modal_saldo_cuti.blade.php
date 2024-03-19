<div class="modal modal_saldo" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah saldo cuti</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form action="{{ url('leave/insertsaldocuti') }}" method="post">
                    @csrf
                    <div class="mb-3">
                        <label for="tahun" class="form-label">Tahun</label>
                        <select name="tahun" id="" class="form-control">
                            <option value="" selected disabled>Tahun</option>
                            @foreach ($tahuns as $tahun)
                            <option value="{{ $tahun }}">{{ $tahun }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="formFile" class="form-label">Saldo tahun ini</label>
                        <input class="form-control" type="number" name="saldo_cuti_tahun_ini">
                    </div>
                    <div class="mb-3">
                        <label for="formFile" class="form-label">Sisa tahun lalu</label>
                        <input class="form-control" type="number" name="sisa_cuti_tahun_lalu">
                    </div>
                    <div class="mb-3">
                        <label for="formFile" class="form-label">Penangguhan tahun lalu</label>
                        <input class="form-control" type="number" name="penangguhan_tahun_lalu">
                    </div>
                    <div>
                        <button class="btn btn-info" type="submit">Simpan</button>
                    </div>
                    <input type="hidden" name="nip" value="{{ $nip }}">
                </form>
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