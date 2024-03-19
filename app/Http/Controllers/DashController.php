<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $data_cuti_aktif = DB::table('leaves as a')->leftJoin('leave_kinds as b', 'a.id_jenis_cuti', '=', 'b.id')->leftJoin('employees as c', 'a.nip_pegawai', '=', 'c.nip')->leftJoin('setuju_cuti as d', 'a.id', '=', 'd.id_cuti')->where('tgl_akhir', '>=', Carbon::now()->format('Y-m-d'))->where('acc_kpn', 'OK')->get();

        $nip = session('employee_nip');
        $tahun = Carbon::now()->format('Y');
        // dd($nip);
        $data_saldo_cuti = DB::table('saldo_cuti')->where('nip', $nip)->where('tahun', $tahun)->first();
        // dd($data_saldo_cuti);
        $penggunaan_tahun_ini = DB::table('hari_efektif')->leftJoin('leaves', 'hari_efektif.id_cuti', '=', 'leaves.id')->where('nip_pegawai', $nip)->where('tahun', $tahun)->sum('jml_hari_efektif');
        // dd($penggunaan_tahun_ini);
        if ($data_saldo_cuti) {

            $sisa_cuti = $data_saldo_cuti->saldo_cuti_tahun_ini + $data_saldo_cuti->sisa_cuti_tahun_lalu + $data_saldo_cuti->penangguhan_tahun_lalu - $penggunaan_tahun_ini;
        }


        return view('dashboard', ['cuti_aktif' => $data_cuti_aktif, 'saldo_cuti' => $data_saldo_cuti, 'penggunaan' => $penggunaan_tahun_ini, 'sisa' => $sisa_cuti ?? 0]);
    }

    public function getChartSurat(Request $request)
    {
        $tahun = $request->tahun_send;
        $jml_surat = [];
        for ($i = 1; $i <= 12; $i++) {
            $jml_perbulan = DB::table('mails')->whereMonth('tanggal_surat', $i)->whereYear('tanggal_surat', $tahun)->count();

            $jml_surat[] = $jml_perbulan;
        }

        return response()->json($jml_surat);
    }
}
