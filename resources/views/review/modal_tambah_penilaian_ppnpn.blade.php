<div class="modal tambah_penilaian" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah petugas Satpam</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ url('ppnpn/insert_penilaian') }}" method="post" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label">Nama</label>
                        <select name="ppnpn_id" id="" class="form-control">
                        <option selected disabled>Pilih</option>
                        @foreach ($ppnpns as $ppnpn)
                        <option value="{{ $ppnpn->id }}">{{ $ppnpn->nama }}</option>
                        @endforeach
                        </select>

                      </select>
                    </div>
                   
                   
                    <div class="mb-3">
                        <label for="bulan" class="form-label">Bulan</label>
                        <select name="bulan" id="" class="form-control">
                            <option selected disabled>Pilih</option>
                            @foreach ($bulans as $key=>$value)
                            <option value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="tahun" class="form-label">tahun</label>
                        <select name="tahun" id="" class="form-control">
                            <option selected disabled>Pilih</option>
                            @foreach ($tahuns as $t)
                            <option value="{{ $t }}">{{ $t }}</option>
                            @endforeach
                        </select>
                    </div>
                   
                    <div class="mb-3">
                        <label for="integritas" class="form-label">Integritas</label>
                       <input type="number" min="50" max="100" name="integritas" id="" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="kedisiplinan" class="form-label">Kedisiplinan</label>
                       <input type="number" min="50" max="100" name="kedisiplinan" id="" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="kerjasama" class="form-label">Kerjasama</label>
                       <input type="number" min="50" max="100" name="kerjasama" id="" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="komunikasi" class="form-label">Komunikasi</label>
                       <input type="number" min="50" max="100" name="komunikasi" id="" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="pelayanan" class="form-label">Pelayanan</label>
                       <input type="number" min="50" max="100" name="pelayanan" id="" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="evaluasi" class="form-label">Evaluasi</label>
                       <textarea name="evaluasi" id="" cols="30" rows="5" class="form-control"></textarea>
                    </div>
                    @if (session('kepegawaian')==true)
                    <div class="mb-3">
                        <label for="jumlah_kehadiran" class="form-label">Jumlah kehadiran</label>
                       <input type="number" name="jumlah_kehadiran" id="" class="form-control">
                    </div>  
                    <div class="mb-3">
                        <label for="jumlah_hari kerja" class="form-label">Jumlah hari kerja</label>
                       <input type="number" name="jumlah_hari kerja" id="" class="form-control">
                    </div>  
                    <input type="hidden" name="is_admin" value="true">
                    @endif
                  
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