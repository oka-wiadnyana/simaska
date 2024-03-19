@extends('layout.main')

@section('content')
<div class="col bg-white shadow p-5">

    <h1>Daftar Template Surat</h1>
    <div class="row mb-2">
        <div class="col">

            @if(Session::get('employee_level')=='admin_umum'||Session::get('employee_level')=='kasubag_uk'||Session::get('employee_level')=='sekretaris'||Session::get('employee_level')=='wakil_ketua'||Session::get('employee_level')=='ketua')
            <button class="btn btn-primary tambah-template-btn">Tambah Template</button>
            @endif
        </div>

    </div>
    <table class="table table-bordered data-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Template</th>
                <th>Keterangan</th>

                <th>Aksi</th>

            </tr>
        </thead>
        <tbody>
            @foreach ($data as $d)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $d->nama_template }}</td>
                <td>{{ $d->keterangan }}</td>
                <td><a href="{{ url('file_template/'.$d->file) }}" class="btn btn-info btn-small">Download</a>
                    @if(Session::get('employee_level')=='admin_umum'||Session::get('employee_level')=='kasubag_uk'||Session::get('employee_level')=='sekretaris'||Session::get('employee_level')=='wakil_ketua'||Session::get('employee_level')=='ketua')<a
                        href="" class="btn btn-warning btn-small edit-btn" data-id="{{ $d->id }}">Edit</a>@endif</td>
            </tr>

            @endforeach
        </tbody>
    </table>
</div>
<div class="modal_container">

</div>




<script type="text/javascript">
    $(document).ready(function () {
        $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });
        $('.tambah-template-btn').click(function (e) {
            e.preventDefault();
            $.ajax({
                type: "get",
                url: "{{ url('modal_template_surat') }}",
                
                dataType: "json",
                success: function (response) {
                    $('.modal_container').html(response.modal);
                    var modal = new bootstrap.Modal(document.querySelector('.modal_container .tambah_template'));
                    modal.show();
                }
            });
        })

        $('.edit-btn').click(function (e) {
            e.preventDefault();
            let id=$(this).data('id');
            console.log(id);
            $.ajax({
                type: "post",
                url: "{{ url('modal_edit_template_surat') }}",
                data:{
                    id
                },
                dataType: "json",
                success: function (response) {
                    $('.modal_container').html(response.modal);
                    var modal = new bootstrap.Modal(document.querySelector('.modal_container .edit_template'));
                    modal.show();
                }
            });
        })
    });
</script>
@endsection