<div class="modal modal_edit_sisa_cuti" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit saldo cuti</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form action="{{ url('leave/editsaldocuti') }}" method="post">
                    @csrf
                    <div class="mb-3">
                        <label for="tahun" class="form-label">Tahun</label>
                        <input class="form-control" type="text" value="{{ $data_cuti->tahun }}" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="formFile" class="form-label">Saldo tahun ini</label>
                        <input class="form-control" type="number" name="saldo_cuti_tahun_ini"
                            value="{{ $data_cuti->saldo_cuti_tahun_ini??0 }}">
                    </div>
                    <div class="mb-3">
                        <label for="formFile" class="form-label">Sisa tahun lalu</label>
                        <input class="form-control" type="number" name="sisa_cuti_tahun_lalu"
                            value="{{ $data_cuti->sisa_cuti_tahun_lalu??0 }}">
                    </div>
                    <div class="mb-3">
                        <label for="formFile" class="form-label">Penangguhan tahun lalu</label>
                        <input class="form-control" type="number" name="penangguhan_tahun_lalu"
                            value="{{ $data_cuti->penangguhan_tahun_lalu??0 }}">
                    </div>
                    <input type="hidden" name="id" value="{{ $data_cuti->id }}">
                    <div>
                        <button class="btn btn-info" type="submit">Simpan</button>
                    </div>

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