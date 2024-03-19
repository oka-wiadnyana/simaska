<div class="modal cetak_register_harian" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Cetak Register Harian</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ url('cetakregisterharian') }}" method="post" enctype="multipart/form-data" target="_blank">
                    @csrf

                    <div class="mb-3">
                        <label for="tanggal" class="form-label">Tanggal</label>
                       <input type="date" class="form-control" name="tanggal">
                    </div>
                    
                    <input type="hidden" name="signer" value="{{ $signer }}">

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