<div class="modal tangguhkan_atasan" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Alasan penangguhan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ url('leave/tangguhkanatasan') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <textarea name="alasan_ditangguhkan" id="" cols="30" rows="5" class="form-control mb-2"></textarea>
                    <input type="hidden" name="id_leave" value="{{ $id_leave }}">

                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </form>
            </div>

        </div>
    </div>
</div>