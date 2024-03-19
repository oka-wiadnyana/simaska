<!DOCTYPE html>

<html>



<head>

    <title>Fullfill Order</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">

    <style>
        body {
            font-family: arial, sans-serif;
            box-sizing: border-box;
        }

        table {
            /* font-family: arial, sans-serif; */
            border-collapse: collapse;
            width: 100%;
        }

        td,
        th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        tr:nth-child(even) {
            background-color: #dddddd;
        }
    </style>

</head>



<body>

    <div class="row mb-3" style="margin-top: 3rem">
        <p style="font-size: 2rem; margin-bottom:0; text-align:center;" class=" p-0 m-0">
            Tanda Terima Barang
        </p>
        <p class="font-weight-bold" style="margin-bottom:0; margin-top:0;  text-align:center;">
            Nomor {{
            $order_data['nomor_pesanan']
            }}</p>
        <p class="font-weight-bold" style="margin-bottom:0; margin-top:0; text-align:center;">
            Tanggal
            {{
            idndate($order_data['tanggal'])['tanggal'] }}</p>
    </div>

    <div style="margin-right: 0">

        <p>Sumber : {{ $dipa }}</p>

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

        @foreach($order_data['items'] as $item)

        <tr>

            <td style="border: 1px solid">{{ $no++ }}</td>

            <td style="border: 1px solid">{{ $item['nama_barang'] }}</td>

            <td style="border: 1px solid">{{ $item['jumlah'] }}</td>

            <td style="border: 1px solid">{{ $item['satuan'] }}</td>



        </tr>

        @endforeach

    </table>


    <br>


    <div class="text-center" style="text-align:center; float:left; width:50%">

        <div>Yang menyerahkan</div>

        <div style="height: 5rem"></div>

        <div>.........................</div>

    </div>





    <div class="text-center" style=" text-align:center; float:right; width:50%">

        <div>Yang menerima</div>

        <div style="height: 5rem"></div>

        <div>.........................</div>

    </div>











</body>



</html>