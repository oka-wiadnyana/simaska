<div class="modal cetak_review_harian" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Cetak Laporan Review Harian</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ url('cetak_register_review_harian_satpam') }}" method="post" enctype="multipart/form-data" target="_blank">
                    @csrf

                    
                    <div class="mb-3">
                        <label for="pic" class="form-label">Tgl Review</label>
                       <input type="date" name="review_date" id="" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="pic" class="form-label">Tgl Laporan</label>
                       <input type="date" name="date" id="" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="pic" class="form-label">Pic</label>
                        <select name="pic_id" id="" class="form-control">
                            <option selected disabled>Pilih</option>
                            @foreach ($pegawai as $p)
                            <option value="{{ $p->id }}">{{ $p->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="higher" class="form-label">Mengetahui</label>
                        <select name="higher_id" id="" class="form-control">
                            <option selected disabled>Pilih</option>
                            @foreach ($pegawai as $p)
                            <option value="{{ $p->id }}">{{ $p->nama }}</option>
                            @endforeach
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