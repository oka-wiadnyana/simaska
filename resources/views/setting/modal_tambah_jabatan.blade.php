<div class="modal tambah_jabatan" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Jabatan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ url('tambahjabatan') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="nama_jabatan" class="form-label">Nama Jabatan</label>
                        <input type="text" class="form-control" id="nama_jabatan" aria-describedby=""
                            name="nama_jabatan">
                    </div>
                  
                    <div class="mb-3">
                        <label for="is_ppnpn" class="form-label">Is PPNPN</label>
                       <select name="is_ppnpn" id="" class="form-control">
                        <option value="" selected disabled>Pilih</option>
                        <option value="Y" >Ya</option>
                        <option value="T" >Tidak</option>
                       </select>
                    </div>
                   
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </form>
            </div>

        </div>
    </div>
</div>