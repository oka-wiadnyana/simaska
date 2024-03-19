<div class="modal edit_pegawai" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit petugas Satpam</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ url('review/tambah_petugas_satpam') }}" method="post" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label">Nama</label>
                       <input type="text" name="name" id="" class="form-control" value="{{ $data->name }}">
                    </div>
                    <div class="mb-3">
                        <label for="nick_name" class="form-label">Nama Pendek</label>
                       <input type="text" name="nick_name" id="" class="form-control" value="{{ $data->nick_name }}">
                    </div>
                    <div class="mb-3">
                        <label for="nip" class="form-label">NIP</label>
                       <input type="text" name="nip" id="" class="form-control" value="{{ $data->nip }}">
                    </div>
                   
                    <div class="mb-3">
                        <label for="foto" class="form-label">Foto</label>
                       <input type="file" name="foto" id="" class="form-control">
                    </div>
                  
                    <input type="hidden" name="foto_lama" value="{{ $data->foto }}">
                    <input type="hidden" name="id" value="{{ $data->id }}">
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