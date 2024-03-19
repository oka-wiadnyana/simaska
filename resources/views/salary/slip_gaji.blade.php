<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Sikreta</title>
    <style>
        * {
            font-size: 1rem;
            font-family: arial, sans-serif;
        }

        body {
            margin-top: 2rem;
            margin-bottom: 2rem;
        }

        table {

            border-collapse: collapse;
            width: 100%;
        }

        td,
        th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 4px;
        }

        /* tr:nth-child(even) {
            background-color: #dddddd;
        } */



        tr td:nth-child(1) {
            width: 1rem
        }

        .rincian-table tr td:nth-child(3) {
            width: 20rem
        }

        table.header tr td:nth-child(2) {
            width: 1rem
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row">
            <h3 class="fw-bold">
                SLIP GAJI</h3>
        </div>
        <div class="row">
            <div class="col border">

                <table class="header">
                    <tr>
                        <td>NAMA</td>
                        <td>:</td>
                        <td>{{ $data->nama }}</td>
                    </tr>
                    <tr>
                        <td>BULAN</td>
                        <td>:</td>
                        <td>{{
                            Illuminate\Support\Carbon::parse($data->tahun.'-'.$data->bulan.'-01')->isoFormat('MMMM')."
                            ".$data->tahun }}</td>
                    </tr>

                </table>
                <div class="col mt-2">
                    <span class="h5 fw-bold">

                        PEMASUKAN

                    </span>
                </div>

                <table class="rincian-table mt-1">

                    <tr>
                        <td>I</td>
                        <td>Gaji</td>
                        <td>{{ number_format($data->gaji,0,',','.') }}</td>
                    </tr>
                    <tr>
                        <td>II</td>
                        <td>Uang Makan</td>
                        <td>{{ number_format($data->uang_makan,0,',','.') }}</td>
                    </tr>
                    <tr>
                        <td>III</td>
                        <td>Remunerasi/Uang Transport</td>
                        <td>{{ number_format($data->remunerasi,0,',','.') }}</td>
                    </tr>

                    <tr>
                        <td class="fw-bold" colspan="2">Total</td>

                        <td class="fw-bold">{{ number_format($total_gaji,0,',','.') }}</td>
                    </tr>
                </table>

                <div class="col mt-2">
                    <span class="h5 fw-bold">

                        POTONGAN

                    </span>
                </div>
                <table class="rincian-table ">
                    <tr>
                        <td>IV</td>
                        <td>Rincian Potongan</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>Potongan BRI</td>
                        <td>{{ number_format($data->potongan_bri,0,',','.') }}</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>Potongan BPD</td>
                        <td>{{ number_format($data->potongan_bpd,0,',','.') }}</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>Iuran Koperasi</td>
                        <td>{{ number_format($data->iuran_koperasi,0,',','.') }}</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>Potongan Koperasi</td>
                        <td>{{ number_format($data->potongan_koperasi,0,',','.') }}</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>Potongan PTWP</td>
                        <td>{{ number_format($data->potongan_ptwp,0,',','.') }}</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>Bea Siswa</td>
                        <td>{{ number_format($data->bea_siswa,0,',','.') }}</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>Ipaspi</td>
                        <td>{{ number_format($data->ipaspi,0,',','.') }}</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>Iuran Korpri</td>
                        <td>{{ number_format($data->iuran_korpri,0,',','.') }}</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>Dana Sosial</td>
                        <td>{{ number_format($data->dana_sosial,0,',','.') }}</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>Simp. Sukarela</td>
                        <td>{{ number_format($data->simp_sukarela,0,',','.') }}</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>Dana Punia</td>
                        <td>{{ number_format($data->dana_punia,0,',','.') }}</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>Yusti Karini</td>
                        <td>{{ number_format($data->yusti_karini,0,',','.') }}</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>Simpanan Pokok</td>
                        <td>{{ number_format($data->sp_koperasi,0,',','.') }}</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>YSDH/IKAHI</td>
                        <td>{{ number_format($data->ysdh_ikahi,0,',','.') }}</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>Lain-lain</td>
                        <td>{{ number_format($data->lain_lain,0,',','.') }}</td>
                    </tr>
                    <tr class="fw-bold">

                        <td colspan="2">Total Potongan</td>
                        <td>{{ number_format($total_potongan,0,',','.') }}</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>Pot Dari Gaji</td>
                        <td>{{ number_format($data->potongan_bank_gaji,0,',','.') }}</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>Pot Dari Remun</td>
                        <td>{{ number_format($data->potongan_bank_remun,0,',','.') }}</td>
                    </tr>

                    <tr>
                        <td class="h5 fw-bold" colspan="2">Sisa Gaji</td>
                        <td class="h5 fw-bold">{{ number_format($sisa,0,',','.') }}</td>
                    </tr>
                </table>



            </div>

        </div>
    </div>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->
</body>

</html>