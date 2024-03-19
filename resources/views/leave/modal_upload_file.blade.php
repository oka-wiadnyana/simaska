<div class="modal upload_surat" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Upload Surat Nomor {{ $data->nomor_surat }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ url('uploadsurat') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="formFile" class="form-label">File</label>
                        <input class="form-control" type="file" id="formFile" name="file_surat">
                    </div>
                    <input type="hidden" name="id_surat" value="{{ $data->id }}">
                    @if($data_update)
                    <input type="hidden" name="data_update" value="true">
                    @endif
                    <button type=" submit" class="btn btn-primary">Submit</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </form>
            </div>

        </div>
    </div>
</div>