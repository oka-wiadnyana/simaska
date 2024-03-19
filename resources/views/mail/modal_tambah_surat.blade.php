<div class="modal tambah_surat" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah surat</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ url('tambahsurat') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    {{-- add when admin --}}
                    @if(Session::get('tu_rt')==true)
                    <div class="mb-3">
                        <label for="kode_surat" class="form-label">Nomor Manual</label>
                        <select name="select_nomor_manual" id="" class="form-control">
                            <option selected disabled>Pilih</option>
                            <option value="Y">Ya</option>
                            <option value="T">Tidak</option>
                        </select>
                    </div>
                    @endif
                    <div class="mb-3 input-nomor-manual">
                        <label for="nomor_manual" class="form-label">Input Nomor</label>
                        <input type="text" class="form-control" id="nomor_manual" aria-describedby=""
                            name="nomor_manual">
                    </div>
                    <div class="mb-3 input-bagian-manual">
                        <label for="kode_surat" class="form-label">Pilih bagian</label>
                        <select name="bagian_manual" id="" class="form-control">
                            <option selected disabled>Pilih</option>
                            @foreach ($bagian as $p)

                            <option value="{{ $p->nama_unit }}">{{ $p->nama_unit }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{--
                    @if(Session::get('employee_level')=='admin_umum'||Session::get('employee_level')=='kasubag_uk'||Session::get('employee_level')=='sekretaris'||Session::get('employee_level')=='wakil_ketua'||Session::get('employee_level')=='ketua')
                    <div class="mb-3">
                        <label for="kode_surat" class="form-label">Pilih bagian</label>
                        <select name="select_bagian_manual" id="" class="form-control">
                            <option selected disabled>Pilih</option>
                            <option value="Y">Ya</option>
                            <option value="T">Tidak</option>
                        </select>
                    </div>
                    @endif --}}

                    <div class="mb-3">
                        <label for="" class="form-label">Pilih Pemohon Surat</label>
                        <select name="employee_id" id="" class="form-control">
                            <option selected disabled>Pilih</option>
                            @foreach ($pegawai as $p)

                            <option value="{{ $p->id }}">{{ $p->nama }}</option>
                            @endforeach

                        </select>
                    </div>
                    {{-- <div class="mb-3">
                        <label for="penandatangan_surat" class="form-label">Penandatangan Surat</label>
                        <select name="penandatangan_surat" id="" class="form-control">
                            <option value="" selected disabled>Pilih</option>
                            <option value="KPN">Ketua</option>
                            <option value="PAN.PN">Panitera</option>
                            <option value="SEK.PN">Sekretaris</option>
                        </select>
                        <small class="text-muted"><i>Apabila penandatangan adalah a.n (atas nama) maka pilih pejabat
                                yang memberikan delegasi
                                kewenangan</i></small>
                    </div> --}}
                    <div class="mb-3">
                        <label for="kode_surat" class="form-label">Kode Surat</label>
                        <select name="kode_surat" id="" class="form-control">
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
                        <label for="tanggal_surat" class="form-label">Tanggal surat</label>
                        <input type="date" class="form-control" id="tanggal_surat" aria-describedby=""
                            name="tanggal_surat" value="{{ $now }}" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="perihal" class="form-label">Perihal</label>
                        <textarea name="perihal" id="" cols="30" rows="5" class="form-control"></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="tujuan" class="form-label">Tujuan</label>
                        <input type="text" class="form-control" id="tujuan" aria-describedby="" name="tujuan">
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