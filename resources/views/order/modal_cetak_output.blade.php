<div class="modal cetak_output" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Cetak Output</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ url('cetakoutput') }}" method="post" enctype="multipart/form-data" target="_blank">
                    @csrf

                    <div class="mb-3">
                        <label for="bulan" class="form-label">Bulan</label>
                        <select name="bulan" id="" class="form-control">
                            <option selected disabled>Pilih</option>
                            @foreach ($bulan as $key=>$value)
                            <option value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="tahun" class="form-label">tahun</label>
                        <select name="tahun" id="" class="form-control">
                            <option selected disabled>Pilih</option>
                            @foreach ($tahun as $t)
                            <option value="{{ $t }}">{{ $t }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="dipa" class="form-label">Dipa</label>
                        <select name="dipa" id="" class="form-control">
                            <option selected disabled>Pilih</option>
                            <option value="099802">099802</option>
                            <option value="099803">099803</option>
                            <option value="ART">ART</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </form>
            </div>

        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('.input-nomor-manual').hide();
        $('[name="select_nomor_manual"]').change(function(){
            $('.input-nomor-manual').hide(500);
            let val=$(this).val();
            console.log(val);
            if(val=='Y') {
                $('.input-nomor-manual').show(500);
                $('input[name="tanggal_surat"]').removeAttr('readonly');
            }else{
                $('.input-nomor-manual').hide(500);
                $('input[name="tanggal_surat"]').attr('readonly',true);
            }
        })
    });
</script>