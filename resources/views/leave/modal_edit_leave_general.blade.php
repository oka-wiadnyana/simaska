<div class="modal modal_edit" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Cuti {{ $data->kode }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ url('leave/editgeneral') }}" method="post" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label for="tanggal_pengajuan" class="form-label">Tanggal pengajuan</label>
                        <input type="date" class="form-control" name="tgl_pengajuan" value="{{ $data->tgl_pengajuan }}">
                    </div>


                    <div class="mb-3">
                        <label for="jenis_cuti" class="form-label">Jenis cuti</label>
                        <select name="id_jenis_cuti" id="" class="form-control">
                            <option selected disabled>Pilih</option>
                            @foreach ($jenis_cuti as $j)

                            <option value="{{ $j->id }}" @selected($j->id==$data->id_jenis_cuti)>{{ $j->jenis }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    @if(session('cuti_is_admin'))
                    <div class="mb-3">
                        <label for="nip_pegawai" class="form-label">NIP Pegawai</label>
                        <select name="nip_pegawai" id="" class="form-control">
                            <option selected disabled>Pilih</option>
                            @foreach ($pegawai as $p)

                            <option value="{{ $p->nip }}" @selected($p->nip==$data->nip_pegawai)>{{ $p->nama }}</option>
                            @endforeach
                        </select>

                    </div>
                    @endif
                    <div class="mb-3">
                        <label for="nip_atasan_langsung" class="form-label">NIP Atasan langsung</label>
                        <select name="nip_atasan_langsung" id="" class="form-control">
                            <option selected disabled>Pilih</option>
                            @foreach ($pegawai as $p)
                            @if ($p->is_atasan_langsung=='Y')
                            <option value="{{ $p->nip }}" @selected($p->nip==$data->nip_atasan_langsung)>{{ $p->nama }}
                            </option>
                            @endif
                            @endforeach
                        </select>

                    </div>
                    <div class="mb-3">
                        <label for="tgl_mulai" class="form-label">Tanggal Mulai</label>
                        <input type="date" class="form-control" name="tgl_mulai" value="{{ $data->tgl_mulai }}">
                    </div>
                    <div class="mb-3">
                        <label for="tgl_akhir" class="form-label">Tanggal Akhir</label>
                        <input type="date" class="form-control" name="tgl_akhir" value="{{ $data->tgl_akhir }}">
                    </div>

                    <div class="mb-3 tahun_ini">
                        <label for="hari_efektif" class="form-label">{{
                            $hari_efektif->isEmpty()||isset($hari_efektif[1])&&$hari_efektif[1]==null||!isset($hari_efektif[1])?'Hari
                            Efektif':'Hari
                            Efektif Tahun Ini' }}</label>
                        <input type="number" class="form-control" name="hari_efektif[0][jml_hari_efektif]"
                            value="{{ !$hari_efektif->isEmpty()?$hari_efektif[0]->jml_hari_efektif:$data->hari_efektif }}">
                        @if (!$hari_efektif->isEmpty())

                        <input type="hidden" name="hari_efektif[0][id]" value="{{ $hari_efektif[0]->id }}">

                        @endif
                    </div>
                    @if (!$hari_efektif->isEmpty()&&isset($hari_efektif[1]))
                    <div class="mb-3 tahun_selanjutnya">
                        <label for="hari_efektif" class="form-label">Hari Efektif Tahun Berikutnya</label>
                        <input type="number" class="form-control" name="hari_efektif[1][jml_hari_efektif]"
                            value="{{ $hari_efektif[1]->jml_hari_efektif }}">
                        <input type="hidden" name="hari_efektif[1][id]" value="{{ $hari_efektif[1]->id }}">
                    </div>
                    @endif

                    <div class="mb-3">
                        <label for="alasan" class="form-label">Alasan cuti</label>
                        <textarea name="alasan" id="" cols="30" rows="5"
                            class="form-control">{{ $data->alasan }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="alamat_cuti" class="form-label">Alamat cuti</label>
                        <textarea name="alamat_cuti" id="" cols="30" rows="5"
                            class="form-control">{{ $data->alamat_cuti }}</textarea>
                    </div>
                    @if (!session('cuti_is_admin'))
                    <input type="hidden" name="nip_pegawai" value="{{ session('employee_nip') }}">
                    @endif
                    <input type="hidden" name="id_leave" value="{{ $data->id }}">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </form>
            </div>

        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
     

        @if(!$hari_efektif->isEmpty()&&isset($hari_efektif[0]))

        $('.tahun_ini').show();
        @else
        $('.tahun_ini').hide();
        @endif
        @if(!$hari_efektif->isEmpty()&&isset($hari_efektif[1]))

            $('.tahun_selanjutnya').show();
        @else
        $('.tahun_selanjutnya').hide();
        @endif

        $('[name="id_jenis_cuti"]').change(function(){
            let id_jenis_cuti=$(this).val();
            if(id_jenis_cuti==1){
                $('.tahun_ini').show(500);
            }else {
                $('.tahun_ini').hide(500);
            }
        })
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