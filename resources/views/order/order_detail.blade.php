@extends('layout.main')

@section('content')
<div class="col bg-white shadow p-5">

    <div class="row">
        <div class="col">
            <h1>Order - Pemenuhan {{ $order_number }}</h1>
        </div>
    </div>

    <div class="row">
        <div class="col">

            <div class="col">
                <span class="bg-success p-2 rounded">Order</span>
                <a href="{{ url('cetakorder/'.$order_id) }}" class="btn btn-warning" target="_blank">Cetak
                    Order</a>
            </div>
            <div class="table-responsive">

                <table class="table tabled-bordered">
                    <thead>
                        <tr>
                            <th>Nama barang</th>
                            <th>Jumlah</th>
                            <th>Satuan</th>
                            @if(Session::get('employee_level')=='admin_umum'||Session::get('employee_level')=='kasubag_uk'||Session::get('employee_level')=='sekretaris'||Session::get('employee_level')=='wakil_ketua'||Session::get('employee_level')=='ketua')
                            <th>Completed</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $no=1;
                        @endphp
                        @foreach ($items as $item)
                        {{-- @php
                        // dd($item)
                        @endphp --}}
                        <tr>
                            <td>{{ $item['nama_barang'] }}</td>
                            <td>{{ $item['jumlah_barang'] }}</td>
                            <td>{{ $item['satuan'] }}</td>
                            @if(Session::get('employee_level')=='admin_umum'||Session::get('employee_level')=='kasubag_uk'||Session::get('employee_level')=='sekretaris'||Session::get('employee_level')=='wakil_ketua'||Session::get('employee_level')=='ketua')
                            <td>@if ($item['complete'])
                                <span class="bg-success rounded p-1 text-white">Completed</span>
                                @else
                                <a href="{{ url('markascompleted/'.$item['id'].'/'. $order_id) }}"
                                    class="bg-warning rounded p-1 text-white">Mark as complete</a>
                                @endif
                            </td>
                            @endif
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        {{-- if umum or above --}}
        @if(Session::get('employee_level')=='admin_umum'||Session::get('employee_level')=='kasubag_uk'||Session::get('employee_level')=='sekretaris'||Session::get('employee_level')=='wakil_ketua'||Session::get('employee_level')=='ketua')
        <div class="col">

            <form action="{{ url('insertpemenuhan') }}" method="post">
                @csrf
                <span class="bg-warning p-2 rounded">Pemenuhan</span>

                <div class="row my-2">
                    <div class="col-6">
                        <label for="">Tanggal pemenuhan</label>
                        <input type="date" id="" class="form-control" name="tanggal_pemenuhan">
                    </div>
                </div>
                <div class="table-responsive">
                    <fieldset disabled>
                        <table class="table tabled-bordered">
                            <thead>
                                <tr>
                                    <th>Nama barang</th>
                                    <th>Jumlah</th>
                                    <th>Satuan</th>
                                    <th>DIPA</th>
                                    <th>Prev</th>
                                </tr>
                            </thead>
                            <tbody>



                                @php
                                $no=1;
                                @endphp
                                @foreach ($items as $item)
                                <tr>
                                    <td>{{ $item['nama_barang'] }}</td>
                                    <td><input type="number" class="form-control" name="jumlah_barang_pemenuhan[]"
                                            data-barang-order="{{ $item['jumlah_barang'] }}" @if ($item['complete'])
                                            @disabled(true) @endif>
                                    </td>
                                    <td><input type="text" class="form-control" name="satuan_barang_pemenuhan[]"
                                            value="{{ $item['satuan'] }}" @if ($item['complete']) @disabled(true)
                                            @endif>
                                    </td>
                                    <td>
                                        <select name="dipa_pemenuhan[]" id="" class="form-control"
                                            @disabled($item['complete'])>
                                            <option value="" selected>Dipa</option>
                                            <option value="099802">01</option>
                                            <option value="099803">03</option>
                                            <option value="ART">ART</option>
                                        </select>
                                    </td>
                                    <td>
                                        <div class="badge bg-success">{{ $item['jumlah_sebelumnya'] }}</div>
                                    </td>
                                    <input type="hidden" name="order_detail_id[]" value="{{ $item['id'] }}"
                                        @disabled($item['complete'])>

                                </tr>
                                @endforeach

                            </tbody>

                        </table>
                    </fieldset>
                </div>
                <input type="hidden" name="order_id" value="{{ $order_id }}">
                <button class="btn btn-info" type="submit">Submit</button>
            </form>
        </div>
        @endif
    </div>
    <div class="row border mt-2 mb-3">

    </div>
    <div class="row">
        <div class="col mb-3">
            <span class="bg-primary p-2 rounded">Pemenuhan sebelumnya</span>
        </div>
        @foreach ($previous_fullfill as $key=>$value)
        {{-- @php
        dd($value['items'][0]['nama_barang']);
        @endphp --}}
        <div class="row">
            <div class="col-6 rounded">
                <span class="bg-secondary p-2 rounded text-white"> {{ $value['tanggal'] }}</span>
                <a href="{{ url('cetakpreviousform/'.$key) }}" class="btn btn-success cetak-form-pemenuhan"
                    target="_blank">Cetak
                    Form</a>

            </div>

        </div>
        <div class="table-responsive">
            <table class="table tabled-bordered">
                <thead>
                    <tr>
                        <th>Nama barang</th>
                        <th>Jumlah</th>
                        <th>Satuan</th>
                        <th>Dipa</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    $no=1;
                    @endphp
                    @foreach ($value['items'] as $v)
                    <tr>
                        <td>{{ $v['nama_barang'] }}</td>
                        <td>{{ $v['jumlah'] }}</td>
                        <td>{{ $v['satuan'] }}</td>
                        <td>{{ $v['dipa'] }}</td>
                        <td><a href="{{ url('orders/delete_fullfills/'.$v['id'].'/'.$order_id) }}"
                                class="btn btn-danger btn-small">Hapus</a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endforeach

    </div>
</div>

<script>
    $(document).ready(function () {
    //    $('[name="jumlah_barang_pemenuhan[]"]').change(function(){
    //     let jumlah_barang_order=$(this).data('barang-order');
    //     let jumlah_barang_pemenuhan=$(this).val();
    //     let satuan_barang_order=$(this).parent().siblings().find('[name="satuan_barang_pemenuhan[]"]').data('satuan-order');
    //     let satuan_barang_pemenuhan=$(this).parent().siblings().find('[name="satuan_barang_pemenuhan[]"]').val();
    //     console.log(jumlah_barang_order,jumlah_barang_pemenuhan,satuan_barang_pemenuhan,jumlah_barang_pemenuhan>=jumlah_barang_order,)
    //     ;
    //     if(jumlah_barang_pemenuhan>=jumlah_barang_order &&satuan_barang_pemenuhan==satuan_barang_order) {
    //         $(this).parent().siblings('.is-complete').html('<span class="bg-success p-2 rounded text-white">Complete</span>');
    //         $(this).parent().siblings('[name="is_complete[]"]').val('Y');
    //     }else {
    //         $(this).parent().siblings('.is-complete').html("");
    //         $(this).parent().siblings('[name="is_complete[]"]').val('');
    //     }
    //    })

    //    $('[name="satuan_barang_pemenuhan[]"]').change(function(){
    //     let satuan_barang_order=$(this).data('satuan-order');
    //     let satuan_barang_pemenuhan=$(this).val();
    //     let jumlah_barang_order=$(this).parent().siblings().find('[name="jumlah_barang_pemenuhan[]"]').data('barang-order');
    //     let jumlah_barang_pemenuhan=$(this).parent().siblings().find('[name="jumlah_barang_pemenuhan[]"]').val();
    //     console.log(jumlah_barang_order,jumlah_barang_pemenuhan,satuan_barang_pemenuhan,jumlah_barang_pemenuhan>=jumlah_barang_order,)
    //     ;
    //     if(jumlah_barang_pemenuhan>=jumlah_barang_order &&satuan_barang_pemenuhan==satuan_barang_order) {
    //         $(this).parent().siblings('.is-complete').html('<span class="bg-success p-2 rounded text-white">Complete</span>');
    //         $(this).parent().siblings('[name="is_complete[]"]').val('Y');
    //     }else {
    //         $(this).parent().siblings('.is-complete').html("");
    //         $(this).parent().siblings('[name="is_complete[]"]').val('');
    //     }
    //    })

    $('[name="tanggal_pemenuhan"]').change(function(){
        $('fieldset').removeAttr('disabled');
    })
    });
</script>
@endsection