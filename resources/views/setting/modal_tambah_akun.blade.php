<div class="modal tambah_akun" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Akun</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ url('tambahakun') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="pegawai" class="form-label">Pegawai</label>
                        <select name="pegawai" id="" class="form-control">
                            <option selected disabled>Pilih pegawai</option>
                            @foreach ($employees as $employee)
                            <option value="{{ $employee->id }}">{{ $employee->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" aria-describedby="" name="username">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" aria-describedby="" name="password">
                    </div>
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                        <input type="password" class="form-control" id="password_confirmation" aria-describedby=""
                            name="password_confirmation">
                    </div>
                    <div class="mb-3">
                        <label for="level" class="form-label">Level</label>
                        <select name="level" id="" class="form-control">
                            <option selected disabled>Pilih level</option>
                            @foreach ($levels as $level)
                            <option value="{{ $level->id }}">{{ $level->nama_level }}</option>
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
       
    });
</script>