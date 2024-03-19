<div class="modal edit_jabatan" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Jabatan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ url('editjabatan') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="nama_jabatan" class="form-label">Nama Jabatan</label>
                        <input type="text" class="form-control" id="nama_jabatan" aria-describedby=""
                            name="nama_jabatan" value="{{ $position->nama_jabatan }}">
                    </div>
                   
                    <div class="mb-3">
                        <label for="is_ppnpn" class="form-label">Is PPNPN</label>
                       <select name="is_ppnpn" id="" class="form-control">
                        <option value="" selected disabled>Pilih</option>
                        <option value="Y" @selected($position->is_ppnpn=='Y')>Ya</option>
                        <option value="T" @selected(!$position->is_ppnpn || $position->is_ppnpn=='T' )>Tidak</option>
                       </select>
                    </div>
                    
                    
                    <input type="hidden" name="id_jabatan" value="{{ $position->id }}">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </form>
            </div>

        </div>
    </div>
</div>