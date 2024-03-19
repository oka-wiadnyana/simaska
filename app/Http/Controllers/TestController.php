<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;


class TestController extends Controller
{
    public function index()
    {
        $data_cuti = DB::table('leaves')->select('leaves.id as id_leave', 'leaves.*', 'hari_efektif.*')->leftJoin('hari_efektif', 'leaves.id', '=', 'hari_efektif.id_cuti')->get();
        // dd($data_cuti);
        // dd(DB::table('employees')->where('nip', '199708052022031005')->first());
        foreach ($data_cuti as $d) {
            if ($d->id_cuti == "") {

                $tahun = Carbon::parse($d->tgl_pengajuan)->format('Y');
                $jml_hari_efektif = $d->hari_efektif;
                $id_cuti = $d->id_leave;

                $data_insert = compact('id_cuti', 'tahun', 'jml_hari_efektif');
                DB::table('hari_efektif')->insert($data_insert);
            }
        }
    }
}
