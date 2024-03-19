<div class="modal edit_unit" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Unit</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ url('editunit') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="nama_unit" class="form-label">Nama Bagian</label>
                        <input type="text" class="form-control" id="nama_unit" aria-describedby="" name="nama_unit"
                            value="{{ $unit->nama_unit }}">
                    </div>
                    <input type="hidden" name="id_unit" value="{{ $unit->id }}">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </form>
            </div>

        </div>
    </div>
</div>