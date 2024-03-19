<div class="modal tambah_sk" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah SK</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ url('tambahsk') }}" method="post" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label for="kode_surat" class="form-label">Nomor Manual</label>
                        <select name="select_nomor_manual" id="" class="form-control">
                            <option selected disabled>Pilih</option>
                            <option value="Y">Ya</option>
                            <option value="T">Tidak</option>
                        </select>
                    </div>

                    <div class="mb-3 input-nomor-manual">
                        <label for="nomor_manual" class="form-label">Input Nomor</label>
                        <input type="text" class="form-control" id="nomor_manual" aria-describedby=""
                            name="nomor_manual">
                    </div>

                    <div class="mb-3">
                        <label for="kode_sk" class="form-label">Kode SK</label>
                        <select name="kode_sk" id="" class="form-control">
                            <option value="" selected disabled>Pilih</option>
                            @foreach ($klasifikasi as $k)
                            <option value="{{ $k->kode }}">{{ $k->kode.' | '.$k->keterangan }}</option>
                            @endforeach
                        </select>
                        <small class="text-muted"><i>Lihat penejelasan detail kode <a
                                    href="{{ asset('klasifikasi_surat/KLASIFIKASI.pdf') }}"
                                    target="_blank">disini</a></i></small>
                    </div>
                    <div class="mb-3">
                        <label for="penandatangan" class="form-label">Penandatangan</label>
                        <select name="penandatangan" id="" class="form-control">
                            <option value="" selected disabled>Pilih</option>

                            <option value="KPT">Ketua</option>
                            <option value="PAN">Panitera</option>
                            <option value="SEK">Sekretaris</option>

                        </select>

                    </div>

                    <div class="mb-3">
                        <label for="tanggal_sk" class="form-label">Tanggal SK</label>
                        <input type="date" class="form-control" id="tanggal_sk" aria-describedby="" name="tanggal_sk">
                    </div>
                    <div class="mb-3">
                        <label for="tentang" class="form-label">Tentang</label>
                        <textarea name="tentang" id="" cols="30" rows="5" class="form-control"></textarea>
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
               
            }else{
                $('.input-nomor-manual').hide(500);
              
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