@extends('layout.main')

@section('content')
<div class="col bg-white shadow p-5">

    <h1>Daftar Gaji</h1>



    <table class="table table-bordered data-table">
        <thead>
            <tr>
                <th>No</th>
                <th>NIP</th>
                <th>Bulan</th>
                <th>Tahun</th>
                <th>Total Gaji</th>
                <th>Total Potongan</th>
                <th>Sisa</th>
                <th>Aksi</th>

            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>
<div class="modal_container">

</div>




<script type="text/javascript">
    $(document).ready(function () {
    var table = $('.data-table').DataTable({
          processing: true,
          serverSide: true,
          ajax: `{{ url('getsalarylist') }}`,
          columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
              {data: 'nama', name: 'nama'},
              {data: 'bulan_full', name: 'bulan_full'},
              {data: 'tahun', name: 'tahun'},
              {data: 'total_gaji', name: 'total_potongan'},
              {data: 'total_potongan', name: 'total_potongan'},
              {data: 'sisa_gaji', name: 'sisa_gaji'},
              {data: 'action', name: 'action'},
            
          ],
          responsive:true
      });


      $('.import').click(function(e){
        e.preventDefault();
        let url =$(this).attr('href');
        $.ajax({
            type: "get",
            url: `${url}`,
            
            dataType: "json",
            success: function (response) {
                console.log(response.modal)
                $('.modal_container').html(response.modal);
                var modalTambahSurat = new bootstrap.Modal(document.querySelector('.modal_container .import'));
                modalTambahSurat.show();
            }
        });
      })
});

</script>
@endsection