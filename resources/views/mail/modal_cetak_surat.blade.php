<div class="modal cetak_surat" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Cetak surat</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ url('cetak_surat') }}" method="post" enctype="multipart/form-data" target="_blank">
                    @csrf
                    {{-- add when admin --}}

                    <div class="mb-3">
                        <label for="nomor_perkara" class="form-label">Nomor perkara</label>
                        <input class="form-control" type="text" name="nomor_perkara" id="">
                    </div>

                    <div class="mb-3">
                        <label for="jenis_surat" class="form-label">Jenis Pengantar</label>
                        <select name="jenis_surat" id="" class="form-control">
                            <option selected disabled>Pilih</option>
                            <option value="pengantar_penahanan">Penahanan hakim</option>
                            <option value="pengantar_hari_sidang">Hari sidang</option>
                            <option value="perpanjangan_penahanan">Perpanjangan penahanan</option>
                            <option value="petikan_putusan">Petikan</option>
                            <option value="salinan_putusan">Salinan</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="jenis_penahanan" class="form-label">Jenis Penahanan</label>
                        <select name="jenis_penahanan" id="" class="form-control">
                            <option selected disabled>Pilih</option>
                            <option value="Y">Ditahan di rutan</option>
                            <option value="T">Tidak ditahan di rutan</option>
                        </select>
                    </div>
                    <div class="detail_penahanan mb-2">
                        <div class="col">
                            <a href="" class="btn btn-success tambah_penahanan">Tambah penahanan</a>
                        </div>
                        <div class="row flex-column list_penahanan">
                            <div class="col">
                                <div class="mb-3">
                                    <label for="nomor_penahanan" class="form-label">Nomor penahanan</label>
                                    <input class="form-control" type="text" name="nomor_penahanan[]" id="">
                                </div>

                                <div class="mb-3">
                                    <label for="nama_terdakwa" class="form-label">Nama Terdakwa</label>
                                    <input class="form-control" type="text" name="nama_terdakwa[]" id="">
                                </div>
                            </div>

                        </div>

                    </div>
                    <div class="detail_petikan mb-2">

                        <div class="row flex-column">
                            <div class="col">

                                <div class="mb-3">
                                    <label for="nama_terdakwa_petikan" class="form-label">Nama Terdakwa I</label>
                                    <input class="form-control" type="text" name="nama_terdakwa_petikan" id="">
                                </div>
                                <div class="mb-3">
                                    <label for="jumlah_terdakwa" class="form-label">Jumlah Terdakwa</label>
                                    <select name="jumlah_terdakwa" id="" class="form-control">
                                        <option selected disabled>Pilih</option>
                                        <option value="1">1 orang</option>
                                        <option value="2">Lebih dari 1 orang</option>

                                    </select>
                                </div>
                            </div>

                        </div>

                    </div>

                    <input type="hidden" name="id_surat" value="{{ $id_surat }}">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </form>
            </div>

        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('.detail_penahanan').hide();
        $('.detail_petikan').hide();
      
        
        $('[name="jenis_surat"]').change(function(){
        if($(this).val()=='petikan_putusan'||$(this).val()=='salinan_putusan') {

            $('.detail_penahanan').hide(500);
            $('.detail_petikan').show(500);
            $('[name="jenis_penahanan"]').show(500);
        }else if($(this).val()=='pengantar_hari_sidang'){
            
            $('.detail_penahanan').hide(500);
            $('.detail_petikan').show(500);
            $('[name="jenis_penahanan"]').hide(500);
        }else{
            
            $('.detail_penahanan').show(500);
            $('.detail_petikan').hide(500);
            $('[name="jenis_penahanan"]').show(500);
        }
          
        })

        $('.tambah_penahanan').click(function (e) { 
            e.preventDefault();
            $('.list_penahanan').append(
                ` <div class="col">
                    <hr>
                <div class="mb-3">
                    <label for="nomor_penahanan" class="form-label">Nomor penahanan</label>
                    <input class="form-control" type="text" name="nomor_penahanan[]" id="">
                </div>
               
                <div class="mb-3">
                     <label for="nama_terdakwa" class="form-label">Nomor penahanan</label>
                    <input class="form-control" type="text" name="nama_terdakwa[]" id="">
                </div>
                
                    <a href="" class="btn btn-danger hapus_penahanan">Hapus</a>
                </div>
                `
            )
         })

         $('.list_penahanan').on('click','.hapus_penahanan',function(e){
            e.preventDefault();
            $(this).parent().remove();
         })
       
    });
</script>