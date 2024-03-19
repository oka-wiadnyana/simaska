<div class="modal modal_import" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Upload File</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ url('goods/importexcel') }}" method="post" enctype="multipart/form-data">
                    @csrf


                    <div class="mb-3">
                        <label for="formFile" class="form-label">File</label>
                        <input class="form-control" type="file" id="formFile" name="file">
                    </div>

                    <button type=" submit" class="btn btn-primary">Submit</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </form>
            </div>

        </div>
    </div>
</div>