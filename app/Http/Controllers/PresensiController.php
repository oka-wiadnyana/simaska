<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use PDF;


class PresensiController extends Controller
{
    //

    public function modal_presensi(Request $request)
    {
        $timezone = 'Asia/Makassar';
        $date = Carbon::now($timezone)->isoFormat('dddd, DD MMMM Y');
        $time = Carbon::now($timezone)->format('H:i:s');
        $date_input = Carbon::now($timezone)->format('Y-m-d');
        $nip = session('employee_nip');
        $data_presensi = DB::table('presensi')->where('nip', $nip)->where('tanggal', $date_input)->first();

        return response()->json(['modal' => view('presensi.modal_presensi', ['date' => $date, 'time' => $time, 'date_input' => $date_input, 'data_presensi' => $data_presensi])->render()]);
    }

    public function insert(Request $request)
    {
        $request_form = $request->all();

        $nip = session('employee_nip');
        $input = Arr::except($request_form, '_token');
        $input = array_merge($input, ['nip' => $nip]);

        DB::table('presensi')->insert($input);
        return redirect()->back()->with('success', 'Presensi berhasil diinput');
    }

    public function laporan_umum(Request $request)
    {

        $bulans = [];
        for ($i = 1; $i <= 12; $i++) {
            $bulans[] = ['month_number' => $i, 'month_name' => Carbon::create()->month($i)->isoFormat('MMMM')];
        }

        $tahuns = [];
        for ($i = 0; $i <= 10; $i++) {
            $tahuns[] = date('Y') - $i;
        }

        return view('presensi.laporan_umum', ['bulans' => $bulans, 'tahuns' => $tahuns]);
    }

    public function get_table_umum(Request $request)
    {
        $tanggal = $request->tanggal ?? Carbon::now()->format('Y-m-d');

        $data_presensi = DB::table('employees as a')->leftJoin('presensi as b', 'a.nip', '=', 'b.nip')->where('tanggal', $tanggal)->orderBy('pukul', 'asc')->get();

        return response()->json([view('presensi.table_umum', ['data' => $data_presensi])->render()]);
    }

    public function cetak_laporan_umum(Request $request)
    {
        $tanggal = $request->tanggal ?? Carbon::now()->format('Y-m-d');

        $data_presensi = DB::table('employees as a')->leftJoin('presensi as b', 'a.nip', '=', 'b.nip')->where('tanggal', $tanggal)->orderBy('pukul', 'asc')->get();

        $pdf = PDF::loadView('presensi.register_umum', ["data" => $data_presensi])->setPaper('a4', 'landscape');

        return $pdf->download('Register-Presensi-' . $tanggal . '.pdf');
    }

    public function laporan_pribadi(Request $request)
    {

        $bulans = [];
        for ($i = 1; $i <= 12; $i++) {
            $bulans[] = ['month_number' => $i, 'month_name' => Carbon::create()->month($i)->isoFormat('MMMM')];
        }

        $tahuns = [];
        for ($i = 0; $i <= 10; $i++) {
            $tahuns[] = date('Y') - $i;
        }

        return view('presensi.laporan_pribadi', ['bulans' => $bulans, 'tahuns' => $tahuns]);
    }

    public function get_table_pribadi(Request $request)
    {
        $bulan = $request->bulan ?? Carbon::now()->format('m');
        $tahun = $request->tahun ?? Carbon::now()->format('Y');

        $data_presensi = DB::table('employees as a')->leftJoin('presensi as b', 'a.nip', '=', 'b.nip')->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun)->where('a.nip', session('employee_nip'))->orderBy('tanggal', 'asc')->get();

        return response()->json([view('presensi.table_pribadi', ['data' => $data_presensi])->render()]);
    }
}
