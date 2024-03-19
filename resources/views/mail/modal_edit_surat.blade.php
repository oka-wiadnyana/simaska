<div class="modal edit_surat" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Surat</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ url('editsurat') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="kode_surat" class="form-label">Kode Surat</label>
                        <input type="text" class="form-control" id="kode_surat" aria-describedby="" name="kode_surat"
                            value="{{ $kode_surat }}">
                    </div>
                    <div class="mb-3">
                        <label for="tanggal_surat" class="form-label">Tanggal surat</label>
                        <input type="date" class="form-control" id="tanggal_surat" aria-describedby=""
                            name="tanggal_surat" value="{{ $data->tanggal_surat }}" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="perihal" class="form-label">Perihal</label>
                        <textarea name="perihal" id="" cols="30" rows="5"
                            class="form-control">{{ $data->perihal }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Pilih Pemohon Surat</label>
                        <select name="employee_id" id="" class="form-control">
                            <option selected disabled>Pilih</option>
                            @foreach ($pegawai as $p)

                            <option value="{{ $p->id }}" @selected($p->id==$data->employee_id)>{{ $p->nama }}</option>
                            @endforeach

                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="tujuan" class="form-label">Tujuan</label>
                        <input type="text" class="form-control" id="tujuan" aria-describedby="" name="tujuan" value="{{
                            $data->tujuan }}">
                    </div>
                    <input type="hidden" name="id_surat" value="{{ $data->id }}">
                    <input type="hidden" name="signer" value="{{ $signer }}">

                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </form>
            </div>

        </div>
    </div>
</div>