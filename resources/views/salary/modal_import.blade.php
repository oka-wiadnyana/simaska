<div class="modal import" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Upload File</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ url('importexcel') }}" method="post" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label for="formFile" class="form-label">Bulan</label>
                        <select name="bulan" id="" class="form-control">
                            <option value="" selected disabled>Pilih</option>
                            @for ($i=1;$i<=12;$i++) <option value="{{ $i }}">{{
                                Illuminate\Support\Carbon::parse(date('Y').'-'.$i.'-01')->isoFormat('MMMM') }}</option>
                                @endfor
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="formFile" class="form-label">Tahun</label>
                        <select name="tahun" id="" class="form-control">
                            <option value="" selected disabled>Pilih</option>
                            @for ($i=0;$i<10;$i++) <option value="{{ date('Y')-$i }}">{{ date('Y')-$i }}</option>
                                @endfor
                        </select>
                    </div>
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