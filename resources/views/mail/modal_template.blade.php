<div class="modal tambah_template" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah template</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ url('tambah_template') }}" method="post" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label for="kode_surat" class="form-label">Nama template</label>
                        <input type="text" class="form-control" id="nama_template" aria-describedby=""
                            name="nama_template" />

                    </div>
                    <div class="mb-3">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <textarea name="keterangan" id="" cols="30" rows="5" class="form-control"></textarea>

                    </div>
                    <div class="mb-3">
                        <label for="formFile" class="form-label">File</label>
                        <input class="form-control" type="file" id="formFile" name="file_template">
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
        $('.input-bagian-manual').hide();
        $('[name="select_nomor_manual"]').change(function(){
            $('.input-nomor-manual').hide(500);
          
            let val=$(this).val();
            console.log(val);
            if(val=='Y') {
                $('.input-nomor-manual').show(500);
                $('.input-bagian-manual').show(500);
             
                $('input[name="tanggal_surat"]').removeAttr('readonly');
            }else{
                $('.input-nomor-manual').hide(500);
                $('.input-bagian-manual').hide(500);
              
                $('input[name="tanggal_surat"]').attr('readonly',true);
            }
        })
        // $('[name="select_pemohon_manual"]').change(function(){
          
        //     $('.select_pegawai').hide(500);
        //     let val=$(this).val();
        //     console.log(val);
        //     if(val=='Y') {
              
        //         $('.select_pegawai').show(500);
              
        //     }else{
              
        //         $('.select_pegawai').hide(500);
             
        //     }
        // })
    });
</script>