<div class="modal modal_detail" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Cuti {{ $data->kode }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post" enctype="multipart/form-data">
                    <fieldset disabled>

                        <div class="mb-3">
                            <label for="tanggal_pengajuan" class="form-label">Nomor cuti</label>
                            <input type="number" class="form-control" name="" value="{{ $data->nomor_surat_cuti }}">
                        </div>
                        <div class="mb-3">
                            <label for="tanggal_pengajuan" class="form-label">Tanggal pengajuan</label>
                            <input type="date" class="form-control" name="" value="{{ $data->tgl_pengajuan }}">
                        </div>


                        <div class="mb-3">
                            <label for="" class="form-label">Jenis cuti</label>
                            <input type="text" class="form-control" name="" value="{{ $data->jenis }}">
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Nama Pegawai</label>
                            <input type="text" class="form-control" name="" value="{{ $data->nama_pegawai }}">
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Nama Atasan</label>
                            <input type="text" class="form-control" name="" value="{{ $data->nama_atasan }}">
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Tgl Mulai</label>
                            <input type="date" class="form-control" name="" value="{{ $data->tgl_mulai }}">
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Tgl Akhir</label>
                            <input type="date" class="form-control" name="" value="{{ $data->tgl_akhir }}">
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Hari efektif</label>
                            <input type="text" class="form-control" name="" value="{{ $data->hari_efektif }}">
                        </div>

                        <div class="mb-3">
                            <label for="" class="form-label">Alasan cuti</label>
                            <textarea name="" id="" cols="30" rows="5"
                                class="form-control">{{ $data->alasan }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Alamat cuti</label>
                            <textarea name="" id="" cols="30" rows="5"
                                class="form-control">{{ $data->alamat_cuti }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Status</label>
                            <input name="" id="" cols="30" rows="5" class="form-control" value="{{ $status }}">
                        </div>
                        @if($data->alasan_reject)
                        <div class="mb-3">
                            <label for="" class="form-label">Alasan penolakan</label>
                            <textarea name="" id="" cols="30" rows="5"
                                class="form-control">{{ $data->alasan_reject }}</textarea>
                        </div>
                        @endif
                        @if($data->alasan_ditangguhkan)
                        <div class="mb-3">
                            <label for="" class="form-label">Alasan ditangguhkan</label>
                            <textarea name="" id="" cols="30" rows="5"
                                class="form-control">{{ $data->alasan_ditangguhkan }}</textarea>
                        </div>
                        @endif



                    </fieldset>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </form>
            </div>

        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('.tahun_selanjutnya').hide();
        $('[name="tgl_akhir"]').change(function(){
          
            let tahun_mulai=new Date($('[name="tgl_mulai"]').val()).getFullYear();
            let tahun_akhir=new Date($('[name="tgl_akhir"]').val()).getFullYear();
          console.log($('[name="tgl_mulai"]').val(),tahun_mulai,tahun_akhir);
           if(tahun_mulai!=tahun_akhir) {
            $('.tahun_ini label').text('Hari Efektif Tahun Ini');
            $('.tahun_selanjutnya').show(500);
               
            }else{
                $('.tahun_ini label').text('Hari Efektif')
                $('.tahun_selanjutnya').hide(500);
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