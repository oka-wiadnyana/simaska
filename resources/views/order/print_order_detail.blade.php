<!DOCTYPE html>
<html>

<head>
    <title>Order</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <style>
        * {
            font-family: Arial, Helvetica, sans-serif;
        }
    </style>
</head>

<body>
    <div class="row mb-3" style="margin-top: 3rem">
        <div class="div text-center" style="">
            <p style="line-height:0; font-size: 2rem;" class=" p-0 m-0">Pesanan Barang</p>
        </div>
        <div class="div text-center mt-0">
            <span class="font-weight-bold">Nomor {{ $items[0]['nomor_pesanan'] }}</span>
        </div>
        <div class="div text-center fw-bold">
            <span class="font-weight-bold">Tanggal {{ idndate($tanggal)['tanggal'] }}</span>
        </div>
    </div>

    <table class="table table-bordered">
        <tr style="border: 1px solid">
            <th class="fw-bold" style="border: 1px solid">No</th>
            <th class="fw-bold" style="border: 1px solid">Nama Barang</th>
            <th class="fw-bold" style="border: 1px solid">Jumlah</th>
            <th class="fw-bold" style="border: 1px solid">Satuan</th>

        </tr>
        @php
        $no=1;
        @endphp
        @foreach($items as $item)
        <tr>
            <td style="border: 1px solid">{{ $no++ }}</td>
            <td style="border: 1px solid">{{ $item->nama_barang }}</td>
            <td style="border: 1px solid">{{ $item->jumlah_barang }}</td>
            <td style="border: 1px solid">{{ $item->satuan }}</td>

        </tr>
        @endforeach
    </table>





    <div class="text-center" style="float:right; width:50%">
        <div>Yang memesan</div>
        <div style="height: 5rem"></div>
        <div>.........................</div>
    </div>





</body>

</html>