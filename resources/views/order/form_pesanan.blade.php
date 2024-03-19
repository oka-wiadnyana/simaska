@extends('layout.main')

@section('content')
<div class="col bg-white shadow p-5">

    <h1 class="mb-2">Form Pesanan</h1>
    {{-- @php
    dd($errors)
    @endphp --}}
    {{-- <div class="row my-3">
        <div class="col">
            <span class="rounded-pill bg-primary p-2 display-5">No : {{ $nomor_pesanan }}</span>
        </div>
    </div> --}}
    <form action="{{ url('insertorderdetails') }}" method="post">
        @csrf
        <div class="row">
            <div class="col">
                <button class="btn btn-success tambah-barang-btn">Tambah barang</button>
                {{-- <a href="" class="btn btn-danger cancel-order-btn">Cancel Pesanan</a> --}}
                <button class="btn btn-primary insert-btn" type="submit">Simpan</button>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-md-6 d-md-flex">

                <div class="form-group me-2">
                    <select name="pemesan" id="" class="form-select">
                        <option value="" selected disabled>
                            Pilih pemesan
                        </option>
                        @foreach ($pegawai as $p)
                        <option value="{{ $p->id }}">{{ $p->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <input type="text" name="" id="" class="form-control" disabled
                        value="{{ session('employee_unit') }}">
                </div>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col">

                <table class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Barang</th>
                            <th>Jumlah</th>
                            <th>Satuan</th>
                        </tr>
                    </thead>
                    </tbody>
                    <tr>
                        <td class="no">1</td>
                        <td><select class="form-control select_nama_barang" name="nama_barang[]">
                                <option value="" selected disabled>Pilih barang</option>
                                @foreach ($goods as $good)
                                @if (!$good->kode)
                                <option value="{{ $good->nama_barang }}" data-satuan={{ $good->satuan }}>{{
                                    $good->nama_barang }}
                                </option>
                                @endif
                                @endforeach
                                @foreach ($jenis as $j)
                                <optgroup label="{{ $j->uraian }}">

                                    @foreach ($goods as $good)

                                    @if ($good->kode==$j->kode)
                                    <option value="{{ $good->nama_barang }}" data-satuan={{ $good->satuan }}>{{
                                        $good->nama_barang }}
                                    </option>
                                    @endif
                                    @endforeach
                                </optgroup>
                                @endforeach

                            </select></td>
                        <td><input type="number" class="form-control" name="jumlah_barang[]"></td>
                        <td><input type="text" class="form-control" name="satuan[]" readonly></td>
                        {{-- '<td><input type="button" class="btn btn-danger delete" value="x"></td>'; --}}
                    </tr>
                    </tbody>
                </table>
                {{-- <input type="hidden" name="order_id" value="{{ $order_id }}"> --}}
            </div>

        </div>

    </form>
    <div class="modal_container">

    </div>

    <script type="text/javascript">
        $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    

    $('tbody').on('change','.select_nama_barang',(function(e){

        let satuan=$('option:selected', this).data('satuan');
        $(this).parent().siblings().find('[name="satuan[]"]').val(satuan)
      
  }))



let goods_json="{{ $goods_json }}";
  goods_json=JSON.parse(goods_json.replace(/&quot;/g,'"'));
  console.log(goods_json);
    $('.tambah-barang-btn').click(function(e){
        e.preventDefault();
        console.log(goods_json);
        let no=$('tbody tr').length+1;

        let opt ="";
        for(let good of goods_json) {
            opt+=`<option value="${good.nama_barang}" data-satuan="${good.satuan}">${good.nama_barang}</option>`
            console.log(good);
        }
        // goods_json.forEach(element=>{
        //     opt+`<option value="${element.id}" data-satuan="${element.satuan}">${element.nama_barang}</option>`
        // })
        console.log(opt)
        $('tbody').append(
            `<tr>
                <td class="no">${no}</td>
               
                <td>
                    <select class="form-control select_nama_barang" name="nama_barang[]">
                                <option value="" selected disabled>Pilih barang</option>
                               ${opt}
                            </select> 
                </td>
                <td><input type="number" class="form-control" name="jumlah_barang[]"></td>
                <td><input type="text" class="form-control" name="satuan[]" readonly></td>
                <td><button class="btn btn-danger delete"><i class="bx bx-trash"></i></button></td>
            </tr>
            `
            )
        
    })

    $('tbody').on('click','.delete',function(e){
        // e.preventDefault();
 
        $(this).parent().parent().remove();
        
    })

    $('.cancel-order-btn').click(function (e) { 
        e.preventDefault();
        let order_id=$('[name="order_id"]').val();
        $.ajax({
            type: "post",
            url: "{{ url('cancelorder') }}",
            data: {
                order_id
            },
            dataType: "json",
            success: function (response) {
                $(location).attr('href','{{ url("orders") }}');
            }
        });
     })

    

    
    </script>
    @endsection