<?php

namespace App\Http\Controllers;

use App\Models\SuratKeputusan;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Carbon;
use PDF;

class SuratKeputusanController extends Controller
{
    public function index()
    {
        return view('surat_keputusan/daftar');
    }

    public function getSkData(Request $request)
    {
        $data = SuratKeputusan::orderBy('tanggal_sk', 'desc')->get();
        return Datatables::of($data)
            ->addIndexColumn()

            ->addColumn('action', function ($row) {


                $actionBtn = '<a href="" class="edit-btn btn-success btn-sm" data-id="' . $row->id . '">Edit</a> <a href="" class="delete-btn btn-danger btn-sm"data-id="' . $row->id . '">Delete</a>';

                return $actionBtn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function modalTambahSk(Request $request)
    {

        $klasifikasi = DB::table('klasifikasi_kka')->get();
        return response()->json(['modal' => view('surat_keputusan.modal_tambah_sk', ['klasifikasi' => $klasifikasi])->render()]);
    }

    public function insert(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'tanggal_sk' => 'required',
                'tentang' => 'required',
                'kode_sk' => 'required',
                'penandatangan' => 'required',

            ],

            [
                'tanggal_sk.required' => 'Tanggal SK harus diisi',
                'tentang.required' => 'Tentang harus diisi',
                'kode_sk.required' => 'Kode SK harus diisi',
                'penandatangan.required' => 'Penandatangan harus diisi',

            ]
        );

        if ($validator->fails()) {
            return redirect('surat_keputusan')
                ->withErrors($validator)
                ->withInput();
            // dd($validator);
        }
        $validated = $validator->safe();

        $nomor_manual = $request->nomor_manual;
        $kode_ttd = $request->penandatangan;
        $kode_ttd = $request->penandatangan == 'KPT' ? 'KPT' : ($request->penandatangan == 'PAN' ? 'PAN.PN' : 'SEK.PN');
        $array_tanggal = explode('-', $validated['tanggal_sk']);
        $month = $array_tanggal[1];
        $tahun = $array_tanggal[0];
        $month_rome = "";
        $kode_wilayah = "W24-U";
        switch ($month) {
            case "1":
                $month_rome = 'I';
                break;
            case "2":
                $month_rome = 'II';
                break;
            case "3":
                $month_rome = 'III';
                break;
            case "4":
                $month_rome = 'IV';
                break;
            case "5":
                $month_rome = 'V';
                break;
            case "6":
                $month_rome = 'VI';
                break;
            case "7":
                $month_rome = 'VII';
                break;
            case "8":
                $month_rome = 'VIII';
                break;
            case "9":
                $month_rome = 'IX';
                break;
            case "10":
                $month_rome = 'X';
                break;
            case "11":
                $month_rome = 'XI';
                break;
            case "12":
                $month_rome = 'XII';
                break;
        }

        if ($nomor_manual) {
            $is_continue = explode('.', $nomor_manual);

            if (count($is_continue) == 1) {



                $new_number = $is_continue[0];
            }

            if (count($is_continue) > 1) {



                $new_number = 0;
            }

            $nomor_sk = $nomor_manual . '/' . $kode_ttd . '.' . $kode_wilayah . '/SK.' .  $validated['kode_sk'] . '/' . $month_rome . '/' . $tahun;
        } else {
            $max_nomor = DB::table('surat_keputusan')->whereYear('tanggal_sk', $tahun)->max('nomor_index');
            if ($max_nomor) {

                $new_number = $max_nomor + 1;
            }

            if (!$max_nomor || $max_nomor == 0) {
                $new_number = 1;
            }

            $nomor_sk = $new_number . '/' . $kode_ttd . '.' . $kode_wilayah . '/SK.' .  $validated['kode_sk'] . '/' . $month_rome . '/' . $tahun;
        }

     
        $nomor_sk = $new_number . '/' . $kode_ttd . '.' . $kode_wilayah . '/SK.' .  $validated['kode_sk'] . '/' . $month_rome . '/' . $tahun;

        if (DB::table('surat_keputusan')->insert([
            'nomor_index' => $new_number,
            'nomor_sk' => $nomor_sk,
            'tanggal_sk' => $validated['tanggal_sk'],
            'tentang' => $validated['tentang'],


        ])) {
            return redirect('surat_keputusan')->with('success', 'Data berhasil diinput');
        }
    }

    public function hapusSk(Request $request)
    {
        SuratKeputusan::destroy($request->id);

        return response()->json(['msg' => 'success']);
    }

    public function modalEditSk(Request $request)
    {

        $data_surat = SuratKeputusan::find($request->id);
      
        $klasifikasi = DB::table('klasifikasi_kka')->get();
        return response()->json(['modal' => view('surat_keputusan.modal_edit_sk', ['klasifikasi' => $klasifikasi, 'data_surat' => $data_surat])->render()]);
    }

    public function editSk(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'tanggal_sk' => 'required',
                'tentang' => 'required',


            ],

            [
                'tanggal_sk.required' => 'Tanggal SK harus diisi',
                'tentang.required' => 'Tentang harus diisi',


            ]
        );

        if ($validator->fails()) {
            return redirect('surat_keputusan')
                ->withErrors($validator)
                ->withInput();
            // dd($validator);
        }
        $validated = $validator->safe();

        $kode_sk = $request->kode_sk;
        $array_tanggal = explode('-', $validated['tanggal_sk']);
        $month = $array_tanggal[1];
        $tahun = $array_tanggal[0];
        $month_rome = "";

        switch ($month) {
            case "1":
                $month_rome = 'I';
                break;
            case "2":
                $month_rome = 'II';
                break;
            case "3":
                $month_rome = 'III';
                break;
            case "4":
                $month_rome = 'IV';
                break;
            case "5":
                $month_rome = 'V';
                break;
            case "6":
                $month_rome = 'VI';
                break;
            case "7":
                $month_rome = 'VII';
                break;
            case "8":
                $month_rome = 'VIII';
                break;
            case "9":
                $month_rome = 'IX';
                break;
            case "10":
                $month_rome = 'X';
                break;
            case "11":
                $month_rome = 'XI';
                break;
            case "12":
                $month_rome = 'XII';
                break;
        }

        $data_sk = SuratKeputusan::find($request->id);
        $nomor_array = explode('/', $data_sk->nomor_sk);
        if ($request->penandatangan) {

            $kode_ttd = $request->penandatangan == 'KPN' ? 'KPN' : ($request->penandatangan == 'PAN' ? 'PAN.PN' : 'SEK.PN');
            $kode_ttd_full = $kode_ttd . '.W24-U4';
        } else {
            $kode_ttd_full = $nomor_array[1];
        }

        if ($kode_sk) {
            $nomor_sk_baru = $nomor_array[0] . '/' . $kode_ttd_full . '/SK.' .  $kode_sk . '/' . $month_rome . '/' . $tahun;
        } else {
            $nomor_sk_baru = $nomor_array[0] . '/' . $kode_ttd_full . '/' .   $nomor_array[2] . '/' . $month_rome . '/' . $tahun;
        }


        // if (DB::table('surat_keputusan')->where('id', $request->id)->update([

        //     'nomor_sk' => $nomor_sk_baru,
        //     'tanggal_sk' => $validated['tanggal_sk'],
        //     'tentang' => $validated['tentang'],


        // ])) {
        //     return redirect('surat_keputusan')->with('success', 'Data berhasil diubah');
        // } else {
        //     dd('eror');
        // }

        try {
            DB::table('surat_keputusan')->where('id', $request->id)->update([

                'nomor_sk' => $nomor_sk_baru,
                'tanggal_sk' => $validated['tanggal_sk'],
                'tentang' => $validated['tentang'],


            ]);
            return redirect('surat_keputusan')->with('success', 'Data berhasil diubah');
        } catch (\Exception $e) {
            //throw $th;
            return redirect('surat_keputusan')->with('success', $e->getMessage());
        }
    }

    public function modalCetakRegister()
    {
        $bulan = [
            '1' => 'Januari',
            '2' => 'Februari',
            '3' => 'Maret',
            '4' => 'April',
            '5' => 'Mei',
            '6' => 'Juni',
            '7' => 'Juli',
            '8' => 'Agustus',
            '9' => 'September',
            '10' => 'Oktober',
            '11' => 'Nopember',
            '12' => 'Desember',
        ];

        $tahun = Carbon::now()->format('Y');

        $tahun_array = [];
        for ($i = 0; $i <= 10; $i++) {
            $tahun_array[] = (int)$tahun - $i;
        }

        return response()->json(['modal' => view('surat_keputusan.modal_cetak_register', ['bulan' => $bulan, 'tahun' => $tahun_array])->render()]);
    }

    public function cetakRegister(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [

                'tahun' => 'required',


            ],

            [

                'tahun.required' => 'Tahun harus diisi',

            ]
        );

        if ($validator->fails()) {
            return redirect('mails')
                ->withErrors($validator)
                ->withInput();
        }


        $bulan = $request->bulan;
        $tahun = $request->tahun;
        if ($bulan) {
            $bulan_array = [
                '1' => 'Januari',
                '2' => 'Februari',
                '3' => 'Maret',
                '4' => 'April',
                '5' => 'Mei',
                '6' => 'Juni',
                '7' => 'Juli',
                '8' => 'Agustus',
                '9' => 'September',
                '10' => 'Oktober',
                '11' => 'Nopember',
                '12' => 'Desember',
            ];
            $data_sk = DB::table('surat_keputusan')->whereMonth('tanggal_sk', $bulan)->whereYear('tanggal_sk', $tahun)->orderBy('tanggal_sk', 'desc')->orderBy('nomor_sk')->get();
            $pdf = PDF::loadView('surat_keputusan.register', ["data_sk" => $data_sk, 'bulan' => $bulan_array[$bulan], 'tahun' => $tahun])->setPaper([0, 0, 595.276, 935.433], 'landscape');
        }
        if (!$bulan) {
            $data_sk = DB::table('surat_keputusan')->whereYear('tanggal_sk', $tahun)->orderBy('tanggal_sk', 'desc')->orderBy('nomor_sk')->get();
            $pdf = PDF::loadView('surat_keputusan.register', ["data_sk" => $data_sk,  'tahun' => $tahun])->setPaper([0, 0, 595.276, 935.433], 'landscape');
        }



        return $pdf->download('register-' . $bulan . '-' . $tahun . '.pdf');
    }
}
