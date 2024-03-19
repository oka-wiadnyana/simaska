<div class="modal modal_edit" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Izin</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ url('permission/insert') }}" method="post" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label for="tanggal_pengajuan" class="form-label">Tanggal pengajuan</label>
                        <input type="date" class="form-control" name="tanggal" value="{{ $data->tanggal }}">
                    </div>
                    <div class="mb-3">
                        <label for="tanggal_pengajuan" class="form-label">Pukul</label>
                        <input type="time" class="form-control" name="jam_awal" min="08:00" max="16:30"
                            value="{{ $data->jam_awal }}">
                        <span>s.d</span>
                        <input type="time" class="form-control" name="jam_akhir" min="08:00" max="16:30"
                            value="{{ $data->jam_akhir }}">
                    </div>


                    @if(session('cuti_is_admin'))
                    <div class="mb-3">
                        <label for="nip_pegawai" class="form-label">NIP Pegawai</label>
                        <select name="nip" id="" class="form-control">
                            <option selected disabled>Pilih</option>
                            @foreach ($pegawai as $p)

                            <option value="{{ $p->nip }}" @selected($p->nip==$data->nip)>{{ $p->nama }}</option>
                            @endforeach
                        </select>

                    </div>
                    @endif
                    <div class="mb-3">
                        <label for="nip_atasan_langsung" class="form-label">NIP Atasan langsung</label>
                        <select name="nip_atasan" id="" class="form-control">
                            <option selected disabled>Pilih</option>
                            @foreach ($pegawai as $p)
                            @if ($p->is_atasan_langsung=='Y')
                            <option value="{{ $p->nip }}" @selected($p->nip==$data->nip_atasan)>{{ $p->nama }}</option>
                            @endif
                            @endforeach
                        </select>

                    </div>

                    <div class="mb-3">
                        <label for="alasan" class="form-label">Alasan</label>
                        <textarea name="alasan" id="" cols="30" rows="5"
                            class="form-control">{{ $data->alasan }}</textarea>
                    </div>

                    @if (!session('cuti_is_admin'))
                    <input type="hidden" name="nip" value="{{ session('employee_nip') }}">

                    @endif
                    <input type="hidden" name="id" value="{{ $data->id_permission }}">
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