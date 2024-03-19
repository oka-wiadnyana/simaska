<div class="modal tambah_pegawai" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Pegawai</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ url('tambahpegawai') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="nama_pegawai" class="form-label">Nama Pegawai</label>
                        <input type="text" class="form-control" id="nama_pegawai" aria-describedby=""
                            name="nama_pegawai">
                    </div>
                    <div class="mb-3">
                        <label for="nip" class="form-label">NIP</label>
                        <input type="text" class="form-control" id="nip" aria-describedby="" name="nip">
                    </div>
                    <div class="mb-3">
                        <label for="jabatan" class="form-label">Jabatan</label>
                        <select name="jabatan" id="" class="form-control">
                            <option selected disabled>Pilih jabatan</option>
                            @foreach ($positions as $position)
                            <option value="{{ $position->id }}">{{ $position->nama_jabatan }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="unit" class="form-label">Bagian</label>
                        <select name="unit" id="" class="form-control">
                            <option selected disabled>Pilih bagian</option>
                            @foreach ($units as $unit)
                            <option value="{{ $unit->id }}">{{ $unit->nama_unit }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="golongan" class="form-label">Pangkat/Golongan</label>
                        <select name="golongan" id="" class="form-control">
                            <option selected disabled>Pilih pangkat</option>
                            @foreach ($ranks as $rank)
                            <option value="{{ $rank->id }}">{{ $rank->pangkat.'/'.$rank->golongan }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="nomor_hp" class="form-label">Nomor HP</label>
                        <input type="text" class="form-control" id="nomor_hp" aria-describedby="" name="nomor_hp">
                    </div>
                    <div class="mb-3">
                        <label for="is_atasan_langsung" class="form-label">Atasan langsung</label>
                        <select name="is_atasan_langsung" id="" class="form-control">
                            <option selected disabled>Pilih...</option>

                            <option value="Y">Ya</option>
                            <option value="T">Tidak</option>

                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="tgl_awal_mk" class="form-label">Tgl Awal Masa Kerja</label>
                        <input type="date" class="form-control" id="tgl_awal_mk" aria-describedby="" name="tgl_awal_mk">
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