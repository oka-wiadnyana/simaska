<div class="modal edit_pegawai" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Pegawai</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ url('editpegawai') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="nama_pegawai" class="form-label">Nama Pegawai</label>
                        <input type="text" class="form-control" id="nama_pegawai" aria-describedby=""
                            name="nama_pegawai" value="{{ $pegawai->nama }}">
                    </div>
                    <div class="mb-3">
                        <label for="nip" class="form-label">NIP</label>
                        <input type="text" class="form-control" id="nip" aria-describedby="" name="nip"
                            value="{{ $pegawai->nip }}">
                    </div>
                    <div class="mb-3">
                        <label for="jabatan" class="form-label">Jabatan</label>
                        <select name="jabatan" id="" class="form-control">
                            <option selected disabled>Pilih jabatan</option>
                            @foreach ($positions as $position)
                            <option value="{{ $position->id }}" @if ($pegawai->position_id == $position->id)
                                selected
                                @endif>{{ $position->nama_jabatan }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="unit" class="form-label">Bagian</label>
                        <select name="unit" id="" class="form-control">
                            <option selected disabled>Pilih bagian</option>
                            @foreach ($units as $unit)
                            <option value="{{ $unit->id }}" @if ($pegawai->unit_id == $unit->id)
                                selected
                                @endif >{{ $unit->nama_unit }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="golongan" class="form-label">Pangkat/Golongan</label>
                        <select name="golongan" id="" class="form-control">
                            <option selected disabled>Pilih pangkat</option>
                            @foreach ($ranks as $rank)
                            <option value="{{ $rank->id }}" @selected($pegawai->golongan==$rank->id)>{{
                                $rank->pangkat.'/'.$rank->golongan }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="nomor_hp" class="form-label">Nomor HP</label>
                        <input type="text" class="form-control" id="nomor_hp" aria-describedby="" name="nomor_hp"
                            value="{{ $pegawai->nomor_hp }}">
                    </div>
                    <div class="mb-3">
                        <label for="is_atasan_langsung" class="form-label">Atasan langsung</label>
                        <select name="is_atasan_langsung" id="" class="form-control">
                            <option selected disabled>Pilih...</option>

                            <option value="Y" @selected($pegawai->is_atasan_langsung=='Y')>Ya</option>
                            <option value="T" @selected($pegawai->is_atasan_langsung=='T')>Tidak</option>

                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="tgl_awal_mk" class="form-label">Tgl Awal Masa Kerja</label>
                        <input type="date" class="form-control" id="tgl_awal_mk" aria-describedby="" name="tgl_awal_mk"
                            value="{{ $pegawai->tgl_awal_mk }}">
                    </div>
                    <div class="mb-3">
                        <label for="potongan_mk" class="form-label">Potongan Masa Kerja <i>(dalam tahun)</i></label>
                        <input type="number" class="form-control" id="potongan_mk" aria-describedby="" name="potongan_mk"
                            value="{{ $pegawai->potongan_mk }}">
                    </div>
                    <input type="hidden" name="id_pegawai" value="{{ $pegawai->id }}">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </form>
            </div>

        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
    
    });
</script>