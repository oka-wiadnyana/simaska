<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ValidatedInput;
use DataTables;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use Illuminate\Database\Query\Builder;
use PhpOffice\PhpWord\TemplateProcessor;
use PDF;


class LeaveController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request, $jenis = null)
    {
        return view('leave.leave_list', ['jenis' => $jenis]);

        //
    }

    public function getLeavesGeneral(Request $request, $nip = null, $kategori = null)
    {

        if ($nip == 'null') {
            if ($kategori == 'null' || $kategori == 'semua') {
                $data = DB::table('leaves')->select('leaves.id as id_leave', 'leaves.*', 'employees.*', 'positions.*', 'units.*', 'leave_kinds.*', 'setuju_cuti.*')->leftJoin('employees', 'leaves.nip_pegawai', '=', 'employees.nip')->leftJoin('positions', 'employees.position_id', '=', 'positions.id')->leftJoin('units', 'employees.unit_id', '=', 'units.id')->leftJoin('leave_kinds', 'leaves.id_jenis_cuti', '=', 'leave_kinds.id')->leftJoin('setuju_cuti', 'leaves.id', '=', 'setuju_cuti.id_cuti')->orderBy('tgl_pengajuan', 'desc')->get();
            } else {
                $data = DB::table('leaves')->select('leaves.id as id_leave', 'leaves.*', 'employees.*', 'positions.*', 'units.*', 'leave_kinds.*', 'setuju_cuti.*')->leftJoin('employees', 'leaves.nip_pegawai', '=', 'employees.nip')->leftJoin('positions', 'employees.position_id', '=', 'positions.id')->leftJoin('units', 'employees.unit_id', '=', 'units.id')->leftJoin('leave_kinds', 'leaves.id_jenis_cuti', '=', 'leave_kinds.id')->leftJoin('setuju_cuti', 'leaves.id', '=', 'setuju_cuti.id_cuti')->where("$kategori", '<>', null)->where("$kategori", '<>', "")->orderBy('tgl_pengajuan', 'desc')->get();
            }
        }
        if ($nip != 'null') {
            $data = DB::table('leaves')->select('leaves.id as id_leave', 'leaves.*', 'employees.*', 'positions.*', 'units.*', 'leave_kinds.*', 'setuju_cuti.*')->leftJoin('employees', 'leaves.nip_pegawai', '=', 'employees.nip')->leftJoin('positions', 'employees.position_id', '=', 'positions.id')->leftJoin('units', 'employees.unit_id', '=', 'units.id')->leftJoin('leave_kinds', 'leaves.id_jenis_cuti', '=', 'leave_kinds.id')->leftJoin('setuju_cuti', 'leaves.id', '=', 'setuju_cuti.id_cuti')->where('leaves.nip_pegawai', $nip)->orderBy('tgl_pengajuan', 'desc')->get();
        }

        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('status', function ($row) {

                if ($row->acc_ats == null && $row->acc_kpn == null &&  $row->reject_ats == null && $row->reject_kpn == null && $row->ditangguhkan_ats == null && $row->ditangguhkan_kpn == null) {
                    $status = 'Permohonan baru';
                }
                if ($row->acc_ats == "OK" && ($row->acc_kpn == "" || $row->acc_kpn == null) && ($row->reject_kpn == "" || $row->reject_kpn == null) && ($row->ditangguhkan_kpn == "" || $row->ditangguhkan_kpn == null)) {
                    $status = 'Persetujuan Atasan Langsung';
                }
                if ($row->acc_kpn == "OK") {
                    $status = 'Persetujuan KPN';
                }
                if ($row->reject_ats == "X") {
                    $status = 'Ditolak Atasan Langsung';
                }
                if ($row->reject_kpn == "X") {
                    $status = 'Ditolak KPN';
                }
                if ($row->ditangguhkan_ats == "X") {
                    $status = 'Ditangguhkan Atasan Langsung';
                }
                if ($row->ditangguhkan_kpn == "X") {
                    $status = 'Ditangguhkan KPN';
                }


                return $status;
            })
            // ->addColumn('arsip', function ($row) {

            //     if ($row->arsip == null || $row->arsip == "") {
            //         $arsip = "<i class='h1 bx bxs-minus-circle text-danger'></i>";
            //     }
            //     if ($row->arsip != null && $row->file != null) {
            //         $arsip = '<i class="h1 bx bxs-check-circle text-success"></i> <br> (Uploaded)';
            //     }

            //     if ($row->arsip != null && $row->file == null) {
            //         $arsip = '<i class="h1 bx bxs-check-circle text-success"></i> <br> (Hardcopy)';
            //     }

            //     return $arsip;
            // })
            ->addColumn('kode_cuti', function ($row) {

                $href_kode = '<a href="" class="detail-btn badge bg-info" data-id="' . $row->id_leave . '">' . $row->kode . '</a>';

                return $href_kode;
            })
            ->addColumn('action', function ($row) {

                if (($row->acc_ats && $row->acc_ats != "") || ($row->reject_ats && $row->reject_ats != "") || ($row->acc_kpn && $row->acc_kpn != "") || ($row->reject_kpn && $row->reject_kpn != "") || ($row->ditangguhkan_ats && $row->ditangguhkan_ats != "") || ($row->ditangguhkan_kpn && $row->ditangguhkan_kpn != "")) {
                    $nomorBtn = '<a href="" class="nomor-cuti-btn btn-warning btn-sm"data-id="' . $row->id_leave . '">Nomor</a>';
                } else {
                    $nomorBtn = "";
                }
                if (session('kepegawaian')==true) {
                    $actionBtn = '<a href="" class="edit-btn btn-success btn-sm" data-id="' . $row->id_leave . '">Edit</a> <a href="" class="delete-btn btn-danger btn-sm"data-id="' . $row->id_leave . '">Delete</a> ' . $nomorBtn . ' <a href="' . url('leave/cetak_form/' . $row->id_leave) . '" class="cetak-form-btn btn-info btn-sm"data-id="' . $row->id_leave . '" target="_blank">Cetak</a> ';
                } else {
                    if ($row->acc_ats == null && $row->acc_kpn == null &&  $row->reject_ats == null && $row->reject_kpn == null && $row->ditangguhkan_ats == null && $row->ditangguhkan_kpn == null) {
                        $actionBtn = '<a href="" class="edit-btn btn-success btn-sm" data-id="' . $row->id_leave . '">Edit</a> <a href="" class="delete-btn btn-danger btn-sm"data-id="' . $row->id_leave . '">Delete</a> ';
                    } else {
                        $actionBtn = "";
                    }
                }

                return $actionBtn;
            })
            ->rawColumns(['action', 'status', 'kode_cuti'])
            ->make(true);
    }

    public function modalInsertGeneral(Request $request)
    {

        $pegawai = DB::table('employees')->get();
        $jenis_cuti = DB::table('leave_kinds')->get();

        return response()->json(['modal' => view('leave.modal_tambah_leave_general', ['pegawai' => $pegawai, 'jenis_cuti' => $jenis_cuti])->render()]);
    }

    public function insertGeneral(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'tgl_pengajuan' => 'required',
                'id_jenis_cuti' => 'required',
                'nip_pegawai' => 'required',
                'nip_atasan_langsung' => 'required',
                'tgl_mulai' => 'required',
                'tgl_akhir' => 'required',

                'alasan' => 'required',
                'alamat_cuti' => 'required',

            ],

            [
                'tgl_pengajuan.required' => 'Tanggal pengajuan harus diisi',
                'id_jenis_cuti.required' => 'Jenis cuti harus diisi',
                'nip_pegawai.required' => 'NIP Pegawai harus diisi',
                'nip_atasan_langsung.required' => 'NIP Atasan harus diisi',
                'tgl_mulai.required' => 'Tanggal mulai cuti harus diisi',
                'tgl_akhir.required' => 'Tanggal akhir diisi',

                'alasan.required' => 'Alasan harus diisi',
                'alamat_cuti.required' => 'Alamat cuti harus diisi'
            ]
        );

        if ($validator->fails()) {
            return redirect('leave')
                ->withErrors($validator)
                ->withInput();
            // dd($validator);
        }
        $data_insert = $validator->safe()->except(['hari_efektif']);
        $tahun_mulai = Carbon::parse($data_insert['tgl_mulai'])->format('Y');
        $tahun_akhir = Carbon::parse($data_insert['tgl_akhir'])->format('Y');
        // dd($data_insert['id_jenis_cuti']);
        $hari_efektif = $request->hari_efektif;
        if ($data_insert['id_jenis_cuti'] == 1) {
            $saldo_cuti = DB::table('saldo_cuti')->where('nip', $data_insert['nip_pegawai'])->where('tahun', $tahun_mulai)->first();

            if (!$saldo_cuti) {

                return redirect('leave')->with('fail', 'Saldo tahun ' . $tahun_mulai . ' belum diinput');
            }
            $total_saldo_cuti = $saldo_cuti->saldo_cuti_tahun_ini + $saldo_cuti->sisa_cuti_tahun_lalu + $saldo_cuti->penangguhan_tahun_lalu;
            $leave_used = DB::table('hari_efektif as a')->select('jml_hari_efektif')->leftJoin('leaves as b', 'a.id_cuti', '=', 'b.id')->where('nip_pegawai', $data_insert['nip_pegawai'])->where('tahun', $tahun_mulai)->get();
            $jml_cuti = array_sum(Arr::pluck($leave_used, 'jml_hari_efektif'));
            $leave_left = $total_saldo_cuti - $jml_cuti;
            // dd($leave_left);
            // dd($leave_left - $hari_efektif[0]);
            if ($leave_left - $hari_efektif[0] < 0) {
                if (session('kepegawaian')==true) {
                    return redirect('leave')->with('fail', 'Saldo tahun ' . $tahun_mulai . ' tidak cukup');
                }
                if (!session('kepegawaian')==true) {
                    return redirect('leave_user/user')->with('fail', 'Saldo tahun ' . $tahun_mulai . ' tidak cukup');
                }
            }
            if ($hari_efektif[1]) {
                $saldo_cuti2 = DB::table('saldo_cuti')->where('nip', $data_insert['nip_pegawai'])->where('tahun', $tahun_akhir)->first();
                if (!$saldo_cuti2) {
                    if (session('kepegawaian')==true) {

                        return redirect('leave')->with('fail', 'Saldo tahun ' . $tahun_akhir . ' belum diinput');
                    }
                    if (!session('kepegawaian')==true) {

                        return redirect('leave_user/user')->with('fail', 'Saldo tahun ' . $tahun_akhir . ' belum diinput');
                    }
                }
                $total_saldo_cuti2 = $saldo_cuti2->saldo_cuti_tahun_ini + $saldo_cuti2->sisa_cuti_tahun_lalu + $saldo_cuti2->penangguhan_tahun_lalu;
                $leave_used2 = DB::table('hari_efektif as a')->select('jml_hari_efektif')->leftJoin('leaves as b', 'a.id_cuti', '=', 'b.id')->where('nip_pegawai', $data_insert['nip_pegawai'])->where('tahun', $tahun_akhir)->get();
                $jml_cuti2 = array_sum(Arr::pluck($leave_used2, 'jml_hari_efektif'));
                $leave_left2 = $total_saldo_cuti2 - $jml_cuti2;
                if ($leave_left2 - $hari_efektif[1] < 0) {
                    if (session('kepegawaian')==true) {
                        return redirect('leave')->with('fail', 'Saldo tahun ' . $tahun_akhir . ' tidak cukup');
                    }
                    if (!session('kepegawaian')==true) {
                        return redirect('leave_user/user')->with('fail', 'Saldo tahun ' . $tahun_akhir . ' tidak cukup');
                    }
                }
            }
        }



        // dd($leave_left - $hari_efektif[0]);

        $max_kode = DB::table('leaves')->whereYear('tgl_pengajuan', Carbon::parse($data_insert['tgl_pengajuan'])->format('Y'))->max('kode');
        $max_kode = (int)Str::substr($max_kode, 4, 3);
        $next_kode = $max_kode + 1;
        if ($data_insert['id_jenis_cuti'] != 1) {
            $sum_hari_efektif = Carbon::parse($data_insert['tgl_akhir'])->diffInDays(Carbon::parse($data_insert['tgl_mulai'])) + 1;
        }
        if ($data_insert['id_jenis_cuti'] == 1) {

            $sum_hari_efektif = array_sum($hari_efektif);
            // dd($sum_hari_efektif);
        }
        $kode_fix = sprintf('CTI-%03s' . Carbon::parse($data_insert['tgl_pengajuan'])->format('Y'), $next_kode);
        $data_insert = array_merge($data_insert, ['kode' => $kode_fix, 'hari_efektif' => $sum_hari_efektif]);

        $id_cuti = DB::table('leaves')->insertGetId($data_insert);


        if ($data_insert['id_jenis_cuti'] == 1) {

            if ($tahun_mulai == $tahun_akhir) {
                DB::table('hari_efektif')->insert(['id_cuti' => $id_cuti, 'tahun' => $tahun_mulai, 'jml_hari_efektif' => $hari_efektif[0]]);
            }
            if ($tahun_mulai != $tahun_akhir) {
                DB::table('hari_efektif')->insert(['id_cuti' => $id_cuti, 'tahun' => $tahun_mulai, 'jml_hari_efektif' => $hari_efektif[0]]);
                DB::table('hari_efektif')->insert(['id_cuti' => $id_cuti, 'tahun' => $tahun_akhir, 'jml_hari_efektif' => $hari_efektif[1]]);
            }
        }
        if (session('kepegawaian')==true) {

            return redirect('leave')->with('success', 'Data berhasil diinput');
        }
        if (!session('kepegawaian')==true) {

            return redirect('leave_user/user')->with('success', 'Data berhasil diinput');
        }
    }

    public function modalDetailGeneral(Request $request)
    {

        $id_leave = $request->id_leave;
        $data = DB::table('leaves as a')->select('b.nama as nama_pegawai', 'c.nama as nama_atasan', 'a.*', 'b.*', 'c.*', 'd.*', 'e.*')->leftJoin('employees as b', 'a.nip_pegawai', '=', 'b.nip')->leftJoin('employees as c', 'a.nip_atasan_langsung', '=', 'c.nip')->leftJoin('leave_kinds as d', 'a.id_jenis_cuti', '=', 'd.id')->leftJoin('setuju_cuti as e', 'a.id', '=', 'e.id_cuti')->where('a.id', $id_leave)->first();
        // dd($data);

        if ($data->acc_ats == null && $data->acc_kpn == null &&  $data->reject_ats == null && $data->reject_kpn == null && $data->ditangguhkan_ats == null && $data->ditangguhkan_kpn == null) {
            $status = 'Permohonan baru';
        }
        if ($data->acc_ats == "OK" && ($data->acc_kpn == "" || $data->acc_kpn == null) && ($data->reject_kpn == "" || $data->reject_kpn == null) && ($data->ditangguhkan_kpn == "" || $data->ditangguhkan_kpn == null)) {
            $status = 'Persetujuan Atasan Langsung';
        }
        if ($data->acc_kpn == "OK") {
            $status = 'Persetujuan KPN';
        }
        if ($data->reject_ats == "X") {
            $status = 'Ditolak Atasan Langsung';
        }
        if ($data->reject_kpn == "X") {
            $status = 'Ditolak KPN';
        }
        if ($data->ditangguhkan_ats == "X") {
            $status = 'Ditangguhkan Atasan Langsung';
        }
        if ($data->ditangguhkan_kpn == "X") {
            $status = 'Ditangguhkan KPN';
        }



        return response()->json(['modal' => view('leave.modal_detail_leave_general', ['data' => $data, 'status' => $status])->render()]);
    }

    public function modalEditGeneral(Request $request)
    {

        $id_leave = $request->id_leave;
        $data_cuti = DB::table('leaves')->where('id', $id_leave)->first();
        $hari_efektif = DB::table('hari_efektif')->where('id_cuti', $id_leave)->get();

        $pegawai = DB::table('employees')->get();
        $jenis_cuti = DB::table('leave_kinds')->get();

        return response()->json(['modal' => view('leave.modal_edit_leave_general', ['pegawai' => $pegawai, 'jenis_cuti' => $jenis_cuti, 'data' => $data_cuti, 'hari_efektif' => $hari_efektif])->render()]);
    }

    public function editGeneral(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'tgl_pengajuan' => 'required',
                'id_jenis_cuti' => 'required',
                'nip_pegawai' => 'required',
                'nip_atasan_langsung' => 'required',
                'tgl_mulai' => 'required',
                'tgl_akhir' => 'required',
                'hari_efektif.0' => 'required',
                'alasan' => 'required',
                'alamat_cuti' => 'required',

            ],

            [
                'tgl_pengajuan.required' => 'Tanggal pengajuan harus diisi',
                'id_jenis_cuti.required' => 'Jenis cuti harus diisi',
                'nip_pegawai.required' => 'NIP Pegawai harus diisi',
                'nip_atasan_langsung.required' => 'NIP Atasan harus diisi',
                'tgl_mulai.required' => 'Tanggal mulai cuti harus diisi',
                'tgl_akhir.required' => 'Tanggal akhir diisi',
                'hari_efektif.0.required' => 'Hari ekfektif harus diisi',
                'alasan.required' => 'Alasan harus diisi',
                'alamat_cuti.required' => 'Alamat cuti harus diisi'
            ]
        );

        if ($validator->fails()) {
            return redirect('leave')
                ->withErrors($validator)
                ->withInput();
            // dd($validator);
        }

        $data_insert = $validator->safe()->except(['hari_efektif']);


        $hari_efektif = $request->hari_efektif;
        // $only_hari = Arr::pluck($hari_efektif, 'jml_hari_efektif');
        // $sum_hari = 0;
        // $hari_int = Arr::map($only_hari, function ($value, $key) {
        //     return $value;
        // });

        // dd($hari_int);
        // $hari_efektif = [
        //     ['firstName' => 'Jane', 'jml_hari_efektif' => 1],
        //     ['firstName' => 'John', 'jml_hari_efektif' => 3],
        //     ['firstName' => 'Jack', 'jml_hari_efektif' => 5]
        // ];
        // dd($hari_efektif);
        if ($data_insert['id_jenis_cuti'] != 1) {
            $sum_hari_efektif = Carbon::parse($data_insert['tgl_akhir'])->diffInDays(Carbon::parse($data_insert['tgl_mulai'])) + 1;
            // dd($sum_hari_efektif);
        }
        if ($data_insert['id_jenis_cuti'] == 1) {
            $sum_hari_efektif = array_sum(Arr::pluck($hari_efektif, 'jml_hari_efektif'));
        }

        $data_insert = array_merge($data_insert, ['hari_efektif' => $sum_hari_efektif]);
        // dd($data_insert);

        DB::table('leaves')->where('id', $request->id_leave)->update($data_insert);

        $tahun_mulai = Carbon::parse($data_insert['tgl_mulai'])->format('Y');
        $tahun_akhir = Carbon::parse($data_insert['tgl_akhir'])->format('Y');

        if ($data_insert['id_jenis_cuti'] == 1) {

            if ($tahun_mulai == $tahun_akhir) {
                DB::table('hari_efektif')->where('id', $hari_efektif[0]['id'])->update(['jml_hari_efektif' => $hari_efektif[0]['jml_hari_efektif']]);
            }
            if ($tahun_mulai != $tahun_akhir) {
                DB::table('hari_efektif')->where('id', $hari_efektif[0]['id'])->update(['jml_hari_efektif' => $hari_efektif[0]['jml_hari_efektif']]);
                DB::table('hari_efektif')->where('id', $hari_efektif[1]['id'])->update(['jml_hari_efektif' => $hari_efektif[1]['jml_hari_efektif']]);
            }
        }

        return redirect('leave')->with('success', 'Data berhasil diubah');
    }

    public function deleteGeneral(Request $request)
    {
        DB::table('leaves')->delete($request->id_leave);
        session()->flash('success', 'Data berhasil dihapus');
        return response()->json(['msg' => 'success']);
    }

    // PERMOHONAN


    public function permohonan(Request $request, $jenis = null)
    {

        return view('leave.permohonan_list', ['jenis' => $jenis]);
    }

    public function getLeavesPermohonan(Request $request, $jenis = null)
    {

        if ($jenis != 'ketua') {

            $data = DB::table('leaves')->select('leaves.id as id_leave', 'leaves.*', 'employees.*', 'positions.*', 'units.*', 'leave_kinds.*', 'setuju_cuti.*')->leftJoin('employees', 'leaves.nip_pegawai', '=', 'employees.nip')->leftJoin('positions', 'employees.position_id', '=', 'positions.id')->leftJoin('units', 'employees.unit_id', '=', 'units.id')->leftJoin('leave_kinds', 'leaves.id_jenis_cuti', '=', 'leave_kinds.id')->leftJoin('setuju_cuti', 'leaves.id', '=', 'setuju_cuti.id_cuti')->where('leaves.nip_atasan_langsung', session('employee_nip'))->orderBy('tgl_pengajuan', 'desc')->get();
        }
        if ($jenis == 'ketua') {

            $data = DB::table('leaves')->select('leaves.id as id_leave', 'leaves.*', 'employees.*', 'positions.*', 'units.*', 'leave_kinds.*', 'setuju_cuti.*')->leftJoin('employees', 'leaves.nip_pegawai', '=', 'employees.nip')->leftJoin('positions', 'employees.position_id', '=', 'positions.id')->leftJoin('units', 'employees.unit_id', '=', 'units.id')->leftJoin('leave_kinds', 'leaves.id_jenis_cuti', '=', 'leave_kinds.id')->leftJoin('setuju_cuti', 'leaves.id', '=', 'setuju_cuti.id_cuti')->where(function (Builder $query) {
                $query->where('leaves.nip_atasan_langsung', session('employee_nip'))->where('acc_ats', null);
            })->orWhere(function (Builder $query) {
                $query->where('acc_ats', 'OK')->where('reject_ats', null)->where('ditangguhkan_ats', null);
            })->orderBy('tgl_pengajuan', 'desc')->get();
        }



        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('status', function ($row) {

                if ($row->acc_ats == null && $row->acc_kpn == null &&  $row->reject_ats == null && $row->reject_kpn == null && $row->ditangguhkan_ats == null && $row->ditangguhkan_kpn == null) {
                    $status = 'Permohonan baru';
                }
                if ($row->acc_ats == "OK" && ($row->acc_kpn == "" || $row->acc_kpn == null) && ($row->reject_kpn == "" || $row->reject_kpn == null) && ($row->ditangguhkan_kpn == "" || $row->ditangguhkan_kpn == null)) {
                    $status = 'Persetujuan Atasan Langsung';
                }
                if ($row->acc_kpn == "OK") {
                    $status = 'Persetujuan KPN';
                }
                if ($row->reject_ats == "X") {
                    $status = 'Ditolak Atasan Langsung';
                }
                if ($row->acc_ats == "OK" && $row->reject_kpn == "X") {
                    $status = 'Ditolak KPN';
                }
                if ($row->ditangguhkan_ats == "X") {
                    $status = 'Ditangguhkan Atasan Langsung';
                }
                if ($row->ditangguhkan_kpn == "X") {
                    $status = 'Ditangguhkan KPN';
                }


                return $status;
            })
            // ->addColumn('arsip', function ($row) {

            //     if ($row->arsip == null || $row->arsip == "") {
            //         $arsip = "<i class='h1 bx bxs-minus-circle text-danger'></i>";
            //     }
            //     if ($row->arsip != null && $row->file != null) {
            //         $arsip = '<i class="h1 bx bxs-check-circle text-success"></i> <br> (Uploaded)';
            //     }

            //     if ($row->arsip != null && $row->file == null) {
            //         $arsip = '<i class="h1 bx bxs-check-circle text-success"></i> <br> (Hardcopy)';
            //     }

            //     return $arsip;
            // })
            ->addColumn('kode_cuti', function ($row) {

                $href_kode = '<a href="" class="detail-btn badge bg-info" data-id="' . $row->id_leave . '">' . $row->kode . '</a>';

                return $href_kode;
            })
            ->addColumn('action', function ($row) use ($jenis) {


                if ($jenis != 'ketua') {
                    if ($row->acc_ats == "OK" || $row->reject_ats == 'X') {
                        $actionBtn = "";
                    } else {
                        $actionBtn = '<a href="" class="setuju-btn btn-success btn-sm" data-id="' . $row->id_leave . '">Setuju</a> <a href="" class="tolak-btn btn-danger btn-sm"data-id="' . $row->id_leave . '">Tolak</a> <a href="" class="tangguhkan-btn btn-warning btn-sm"data-id="' . $row->id_leave . '">Tangguhkan</a>';
                    }
                }

                if ($jenis == 'ketua') {
                    if ($row->acc_kpn == "OK" || $row->reject_kpn == 'X') {
                        $actionBtn = "";
                    } else {
                        $actionBtn = '<a href="" class="setuju-btn btn-success btn-sm" data-id="' . $row->id_leave . '">Setuju</a> <a href="" class="tolak-btn btn-danger btn-sm"data-id="' . $row->id_leave . '">Tolak</a> <a href="" class="tangguhkan-btn btn-warning btn-sm"data-id="' . $row->id_leave . '">Tangguhkan</a>';
                    }
                }



                return $actionBtn;
            })
            ->rawColumns(['action', 'status', 'kode_cuti'])
            ->make(true);
    }

    public function setujuAtasan(Request $request)
    {
        $id_leave = $request->id_leave;
        if (session('employee_level') != 'ketua') {

            DB::table('setuju_cuti')->updateOrInsert(
                ['id_cuti' => $id_leave],
                ['acc_ats' => 'OK', 'timestamp_acc_ats' => Carbon::now()]
            );
        }
        if (session('employee_level') == 'ketua') {

            DB::table('setuju_cuti')->updateOrInsert(
                ['id_cuti' => $id_leave],
                ['acc_kpn' => 'OK', 'timestamp_acc_kpn' => Carbon::now()]
            );
        }
        session()->flash('success', 'Data berhasil diproses');
        return response()->json(['msg' => 'success']);
    }

    public function modalTolakAtasan(Request $request)
    {
        $id_leave = $request->id_leave;

        return response()->json(['modal' => view('leave.modal_tolak_atasan', ['id_leave' => $id_leave])->render()]);
    }
    public function tolakAtasan(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'alasan_reject' => 'required',


            ],

            [
                'alasan_reject.required' => 'Alasan harus diisi',
            ]
        );

        if ($validator->fails()) {
            if (session('employee_level') == 'ketua') {
                return redirect('leave/permohonan/ketua')
                    ->withErrors($validator)
                    ->withInput();
            }
            if (session('employee_level') != 'ketua') {
                return redirect('leave/permohonan/ketua/non_ketua')
                    ->withErrors($validator)
                    ->withInput();
            }
            // dd($validator);
        }
        $id_leave = $request->id_leave;
        $alasan_reject = $validator->safe();
        if (session('employee_level') != 'ketua') {
            DB::table('setuju_cuti')->updateOrInsert(
                ['id_cuti' => $id_leave],
                ['reject_ats' => 'X', 'alasan_reject' => $alasan_reject['alasan_reject']]
            );
        }
        if (session('employee_level') == 'ketua') {
            DB::table('setuju_cuti')->updateOrInsert(
                ['id_cuti' => $id_leave],
                ['reject_kpn' => 'X', 'alasan_reject' => $alasan_reject['alasan_reject']]
            );
        }


        if (session('employee_level') == 'ketua') {
            return redirect('leave/permohonan/ketua')->with('success', 'Data berhasil diproses');
        }
        if (session('employee_level') != 'ketua') {
            return redirect('leave/permohonan/non_ketua')->with('success', 'Data berhasil diproses');
        }
    }
    public function modalTangguhkanAtasan(Request $request)
    {
        $id_leave = $request->id_leave;

        return response()->json(['modal' => view('leave.modal_tangguhkan_atasan', ['id_leave' => $id_leave])->render()]);
    }
    public function tangguhkanAtasan(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'alasan_ditangguhkan' => 'required',


            ],

            [
                'alasan_ditangguhkan.required' => 'Alasan harus diisi',
            ]
        );

        if ($validator->fails()) {
            if (session('employee_level') == 'ketua') {
                return redirect('leave/permohonan/ketua')
                    ->withErrors($validator)
                    ->withInput();
            }
            if (session('employee_level') != 'ketua') {
                return redirect('leave/permohonan/ketua/non_ketua')
                    ->withErrors($validator)
                    ->withInput();
            }
            // dd($validator);
        }
        $id_leave = $request->id_leave;
        $alasan_ditangguhkan = $validator->safe();
        if (session('employee_level') != 'ketua') {
            DB::table('setuju_cuti')->updateOrInsert(
                ['id_cuti' => $id_leave],
                ['ditangguhkan_ats' => 'X', 'alasan_ditangguhkan' => $alasan_ditangguhkan['alasan_ditangguhkan']]
            );
        }
        if (session('employee_level') == 'ketua') {
            DB::table('setuju_cuti')->updateOrInsert(
                ['id_cuti' => $id_leave],
                ['ditangguhkan_kpn' => 'X', 'alasan_ditangguhkan' => $alasan_ditangguhkan['alasan_ditangguhkan']]
            );
        }


        if (session('employee_level') == 'ketua') {
            return redirect('leave/permohonan/ketua')->with('success', 'Data berhasil diproses');
        }
        if (session('employee_level') != 'ketua') {
            return redirect('leave/permohonan/non_ketua')->with('success', 'Data berhasil diproses');
        }
    }
    public function notifikasiCuti()
    {
        if (session('employee_level') != 'ketua') {

            $data = DB::table('leaves')->select('leaves.id as id_leave', 'leaves.*', 'employees.*', 'positions.*', 'units.*', 'leave_kinds.*', 'setuju_cuti.*')->leftJoin('employees', 'leaves.nip_pegawai', '=', 'employees.nip')->leftJoin('positions', 'employees.position_id', '=', 'positions.id')->leftJoin('units', 'employees.unit_id', '=', 'units.id')->leftJoin('leave_kinds', 'leaves.id_jenis_cuti', '=', 'leave_kinds.id')->leftJoin('setuju_cuti', 'leaves.id', '=', 'setuju_cuti.id_cuti')->where('leaves.nip_atasan_langsung', session('employee_nip'))->where('acc_ats', null)->where('acc_kpn', null)->where('reject_ats', null)->where('reject_kpn', null)->where('ditangguhkan_ats', null)->where('ditangguhkan_kpn', null)->orderBy('tgl_pengajuan', 'desc')->count();
        }

        if (session('employee_level') == 'ketua') {

            $data = DB::table('leaves')->select('leaves.id as id_leave', 'leaves.*', 'employees.*', 'positions.*', 'units.*', 'leave_kinds.*', 'setuju_cuti.*')->leftJoin('employees', 'leaves.nip_pegawai', '=', 'employees.nip')->leftJoin('positions', 'employees.position_id', '=', 'positions.id')->leftJoin('units', 'employees.unit_id', '=', 'units.id')->leftJoin('leave_kinds', 'leaves.id_jenis_cuti', '=', 'leave_kinds.id')->leftJoin('setuju_cuti', 'leaves.id', '=', 'setuju_cuti.id_cuti')->where(function (Builder $query) {
                $query->where('leaves.nip_atasan_langsung', session('employee_nip'))->where('acc_ats', null)->where('acc_kpn', null);
            })->orWhere(function (Builder $query) {
                $query->where('acc_ats', 'OK')->where('acc_kpn', null)->where('reject_ats', null)->where('reject_kpn', null)->where('ditangguhkan_ats', null)->where('ditangguhkan_kpn', null);
            })->orderBy('tgl_pengajuan', 'desc')->count();
        }

        return response()->json(['jml' => $data]);
    }

    public function sisa_cuti()
    {
        $daftar_pegawai = DB::table('employees')->get();
        $tahun_depan = Carbon::now()->format('Y') + 1;
        $tahuns = [];
        for ($i = 0; $i < 10; $i++) {
            $tahuns[] = $tahun_depan - $i;
        }
        return view('leave/daftar_sisa_cuti', ['pegawai' => $daftar_pegawai, 'tahuns' => $tahuns]);
    }
    public function detail_sisa_cuti(Request $request)
    {
        $nip = $request->nip;
        // dd($nip);
        $data_saldo_cuti = DB::table('saldo_cuti')->where('nip', $nip)->get();
        // dd($data_saldo_cuti);
        $data_sisa_cuti = [];
        foreach ($data_saldo_cuti as $d) {
            // dd($d);
            $penggunaan_tahun_ini = DB::table('hari_efektif')->leftJoin('leaves', 'hari_efektif.id_cuti', '=', 'leaves.id')->where('nip_pegawai', $nip)->where('tahun', $d->tahun)->sum('jml_hari_efektif');

            $sisa_cuti = $d->saldo_cuti_tahun_ini + $d->sisa_cuti_tahun_lalu + $d->penangguhan_tahun_lalu - $penggunaan_tahun_ini;

            $data_sisa_cuti[] = array_merge((array)$d, ['penggunaan_tahun_ini' => $penggunaan_tahun_ini, 'sisa_cuti_tahun_ini' => $sisa_cuti]);
        }
        // dd($data_sisa_cuti);

        // $array = [
        //     ['name' => 'Desk'],
        //     ['name' => 'Table'],
        //     ['name' => 'Chair'],
        // ];

        // $sorted = array_values(Arr::sortDesc($array, function (array $value) {
        //     return $value['name'];
        // }));

        // dd($sorted);
        $key_values = array_column($data_sisa_cuti, 'tahun');
        array_multisort($key_values, SORT_DESC, $data_sisa_cuti);
        // dd($data_sisa_cuti);
        // $sorted = array_values(Arr::sortDesc($data_sisa_cuti, function (array $value) {
        //     return $value['tahun'];
        // }));
        return response()->json(['modal' => view('leave.modal_detail_sisa_cuti', ['data_cuti' => $data_sisa_cuti])->render()]);
    }

    public function tambah_saldo_cuti(Request $request)
    {
        $nip = $request->nip;
        // dd($nip);
        $tahun_depan = Carbon::now()->format('Y') + 1;
        $tahuns = [];
        for ($i = 0; $i < 10; $i++) {
            $tahuns[] = $tahun_depan - $i;
        }

        // dd($data_sisa_cuti);
        return response()->json(['modal' => view('leave.modal_saldo_cuti', ['tahuns' => $tahuns, 'nip' => $nip])->render()]);
    }

    public function insertSaldoCuti(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'tahun' => 'required',
                'saldo_cuti_tahun_ini' => 'required',
                'sisa_cuti_tahun_lalu' => 'required',
                'penangguhan_tahun_lalu' => 'required',


            ],

            [
                'tahun.required' => 'Tahun harus diisi',
                'saldo_cuti_tahun_ini.required' => 'Cuti tahun ini harus diisi',
                'sisa_cuti_tahun_lalu.required' => 'Sisa tahun lalu harus diisi',
                'penangguhan_tahun_lalu.required' => 'Penangguhan tahun lalu harus diisi',

            ]
        );

        if ($validator->fails()) {
            return redirect('leave/sisa_cuti')
                ->withErrors($validator)
                ->withInput();
            // dd($validator);
        }

        $data = $validator->safe();
        $nip = $request->nip;

        $tahun_exist = DB::table('saldo_cuti')->where('nip', $nip)->where('tahun', $data->tahun)->first();
        // dd($tahun_exist);
        if ($tahun_exist) {
            return redirect('leave/sisa_cuti')->with('fail', 'Data tahun tersebut sudah ada');
        }
        // dd($data['saldo_cuti_tahun_ini']);
        DB::table('saldo_cuti')->insert(['nip' => $nip, 'tahun' => $data['tahun'], 'saldo_cuti_tahun_ini' => $data['saldo_cuti_tahun_ini'], 'sisa_cuti_tahun_lalu' => $data['sisa_cuti_tahun_lalu'], 'penangguhan_tahun_lalu' => $data['penangguhan_tahun_lalu']]);
        return redirect('leave/sisa_cuti')->with('success', 'Data berhasil diinput');
    }

    public function edit_sisa_cuti(Request $request)
    {
        $tahun = $request->tahun;
        $nip = $request->nip;
        $data_cuti = DB::table('saldo_cuti')->where('nip', $nip)->where('tahun', $tahun)->first();

        return response()->json(['modal' => view('leave.modal_edit_sisa_cuti', ['data_cuti' => $data_cuti])->render()]);
    }

    public function editSaldoCuti(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [

                'saldo_cuti_tahun_ini' => 'required',
                'sisa_cuti_tahun_lalu' => 'required',
                'penangguhan_tahun_lalu' => 'required',


            ],

            [

                'saldo_cuti_tahun_ini.required' => 'Cuti tahun ini harus diisi',
                'sisa_cuti_tahun_lalu.required' => 'Sisa tahun lalu harus diisi',
                'penangguhan_tahun_lalu.required' => 'Penangguhan tahun lalu harus diisi',

            ]
        );

        if ($validator->fails()) {
            return redirect('leave/sisa_cuti')
                ->withErrors($validator)
                ->withInput();
            // dd($validator);
        }

        $data = $validator->safe();
        $id = $request->id;


        // dd($data['saldo_cuti_tahun_ini']);
        DB::table('saldo_cuti')->where('id', $id)->update(['saldo_cuti_tahun_ini' => $data['saldo_cuti_tahun_ini'], 'sisa_cuti_tahun_lalu' => $data['sisa_cuti_tahun_lalu'], 'penangguhan_tahun_lalu' => $data['penangguhan_tahun_lalu']]);
        return redirect('leave/sisa_cuti')->with('success', 'Data berhasil diubah');
    }

    public function cetakRekapSaldoCuti(Request $request)
    {
        $tahun = $request->tahun_select;

        $data_cuti = DB::table('saldo_cuti')->leftJoin('employees', 'saldo_cuti.nip', '=', 'employees.nip')->leftJoin('positions', 'employees.position_id', '=', 'positions.id')->where('tahun', $tahun)->get();

        $data_sisa_cuti = [];
        foreach ($data_cuti as $d) {
            // dd($d);
            if ($d->nip && $d->nip != "-" && $d->nama_jabatan != 'Ketua') {


                $penggunaan_tahun_ini = DB::table('hari_efektif')->leftJoin('leaves', 'hari_efektif.id_cuti', '=', 'leaves.id')->where('nip_pegawai', $d->nip)->where('tahun', $d->tahun)->sum('jml_hari_efektif');

                $sisa_cuti = $d->saldo_cuti_tahun_ini + $d->sisa_cuti_tahun_lalu + $d->penangguhan_tahun_lalu - $penggunaan_tahun_ini;

                $data_sisa_cuti[] = array_merge((array)$d, ['penggunaan_tahun_ini' => $penggunaan_tahun_ini, 'sisa_cuti_tahun_ini' => $sisa_cuti]);
            }
        }

        // dd($data_sisa_cuti);

        return view('leave.rekap_sisa_cuti', ['data' => $data_sisa_cuti, 'tahun' => $tahun]);
    }

    public function cetak_form(Request $request, int $id_cuti)
    {

        $data_cuti = DB::table('leaves as a')->select('a.id as id_cuti', 'b.nama as nama_pegawai', 'e.nama_jabatan as jabatan_pegawai', 'c.nama as nama_atasan', 'g.nama_jabatan as jabatan_atasan_langsung', 'c.nip as nip_atasan_langsung', 'b.tgl_awal_mk as tgl_awal_mk_pegawai', 'a.*', 'b.*', 'c.*', 'd.*', 'e.*', 'f.*', 'g.*')->leftJoin('employees as b', 'a.nip_pegawai', '=', 'b.nip')->leftJoin('employees as c', 'a.nip_atasan_langsung', '=', 'c.nip')->leftJoin('leave_kinds as d', 'a.id_jenis_cuti', '=', 'd.id')->leftJoin('positions as e', 'b.position_id', '=', 'e.id')->leftJoin('setuju_cuti as f', 'a.id', '=', 'f.id_cuti')->leftJoin('positions as g', 'c.position_id', '=', 'g.id')->where('a.id', $id_cuti)->first();
        // dd($data_cuti);

        $current_year = Carbon::parse($data_cuti->tgl_akhir)->format('Y');
        $current_year_1 = $current_year - 1;
        $current_year_2 = $current_year - 2;
        
        $bulan_angka = Carbon::parse($data_cuti->tgl_pengajuan)->format('m');
        switch ($bulan_angka) {
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
        $tahun = Carbon::parse($data_cuti->tgl_pengajuan)->format('Y');
        if ($data_cuti->tgl_awal_mk_pegawai != null) {

            $tgl_awal_masa_kerja = Carbon::parse($data_cuti->tgl_awal_mk_pegawai);
            $diffYear = $tgl_awal_masa_kerja->diffInYears();
            $diffMonth = $tgl_awal_masa_kerja->diffInMonths() % 12;
            $masa_kerja =  $diffYear . ' tahun ' . $diffMonth . ' bulan';
        } else {
            $masa_kerja =  "";
        }

        $kpn = DB::table('employees as a')->leftJoin('positions as b', 'a.position_id', '=', 'b.id')->where('nama_jabatan', 'Ketua')->first();

        $saldo_cuti = DB::table('saldo_cuti')->where('nip', $data_cuti->nip_pegawai)->where('tahun', $current_year)->first();
        $jumlah_sisa_tahun_lalu = $saldo_cuti->sisa_cuti_tahun_lalu + $saldo_cuti->penangguhan_tahun_lalu;
        $penggunaan_tahun_ini = DB::table('hari_efektif')->leftJoin('leaves', 'hari_efektif.id_cuti', '=', 'leaves.id')->where('nip_pegawai', $data_cuti->nip_pegawai)->where('tahun', $current_year)->sum('jml_hari_efektif');
        $hari_efektif_cuti_ini = DB::table('hari_efektif')->leftJoin('leaves', 'hari_efektif.id_cuti', '=', 'leaves.id')->where('nip_pegawai', $data_cuti->nip_pegawai)->where('id_cuti', $id_cuti)->sum('jml_hari_efektif');
        $penggunaan_sebelumnya = $penggunaan_tahun_ini - $hari_efektif_cuti_ini;
        $sisa_sebelumnya = $jumlah_sisa_tahun_lalu - $penggunaan_sebelumnya;
        $penghitungan_cuti_ini = $sisa_sebelumnya - $hari_efektif_cuti_ini;
        // dd($saldo_cuti, $jumlah_sisa_tahun_lalu, $penggunaan_tahun_ini, $hari_efektif_cuti_ini, $penggunaan_sebelumnya, $sisa_sebelumnya, $penghitungan_cuti_ini);



        $templateBA = new TemplateProcessor(public_path('template_cuti/Form-cuti.docx'));
        if ($jumlah_sisa_tahun_lalu == 0) {
            $selisih_tahun_lalu = $hari_efektif_cuti_ini + $penghitungan_cuti_ini;
            $selisih_tahun_ini = abs($penghitungan_cuti_ini);
            $saldo_tahun_ini = $saldo_cuti->saldo_cuti_tahun_ini - $penggunaan_sebelumnya;
            $sisa_sekarang = $saldo_tahun_ini - $hari_efektif_cuti_ini;
            $templateBA->setValue('sisa_tahun_1', $jumlah_sisa_tahun_lalu);
            $templateBA->setValue('sisa_tahun_0', $saldo_tahun_ini . '-' . $hari_efektif_cuti_ini . '=' . $sisa_sekarang);
            $sisa_sekarang = $saldo_tahun_ini - $hari_efektif_cuti_ini;
            $templateBA->setValue('sisa_cuti_tahun_ini', 'Sisa ' . $sisa_sekarang . ' hari kerja');

            $catatan = 'Cuti tahun ' . $current_year . '-' . $data_cuti->alasan;
            $templateBA->setValue('catatan', $catatan);
        }
        if ($sisa_sebelumnya <= 0) {
            $selisih_tahun_lalu = $hari_efektif_cuti_ini + $penghitungan_cuti_ini;
            $selisih_tahun_ini = abs($penghitungan_cuti_ini);
            $saldo_tahun_ini = $saldo_cuti->saldo_cuti_tahun_ini + $jumlah_sisa_tahun_lalu - $penggunaan_sebelumnya;
            $sisa_sekarang = $saldo_tahun_ini - $hari_efektif_cuti_ini;
            $templateBA->setValue('sisa_tahun_1', 0);
            $templateBA->setValue('sisa_tahun_0', $saldo_tahun_ini . '-' . $hari_efektif_cuti_ini . '=' . $sisa_sekarang);
            $templateBA->setValue('sisa_cuti_tahun_ini', 'Sisa ' . $sisa_sekarang . ' hari kerja');
            $catatan = 'Cuti tahun ' . $current_year . '-' . $data_cuti->alasan;
            $templateBA->setValue('catatan', $catatan);
        }
        if ($sisa_sebelumnya > $hari_efektif_cuti_ini) {
            // $selisih_tahun_lalu = $hari_efektif_cuti_ini + $penghitungan_cuti_ini;
            // $selisih_tahun_ini = abs($penghitungan_cuti_ini);
            $sisa_tahun_lalu = $sisa_sebelumnya - $hari_efektif_cuti_ini;
            $templateBA->setValue('sisa_tahun_1', $sisa_sebelumnya . '-' . $hari_efektif_cuti_ini . '=' . $sisa_tahun_lalu);
            $templateBA->setValue('sisa_tahun_0', $saldo_cuti->saldo_cuti_tahun_ini);
            $sisa_sekarang = $saldo_cuti->saldo_cuti_tahun_ini +  $sisa_sebelumnya - $hari_efektif_cuti_ini;
            $templateBA->setValue('sisa_cuti_tahun_ini', 'Sisa ' . $sisa_sekarang . ' hari kerja');
            $catatan = 'Cuti tahun ' . $current_year_1 . ' yang diambil tahun ' . $current_year . '-' . $data_cuti->alasan;
            $templateBA->setValue('catatan', $catatan);
        }
        if ($sisa_sebelumnya < $hari_efektif_cuti_ini) {
            $selisih_tahun_lalu = $hari_efektif_cuti_ini + $penghitungan_cuti_ini;
            $selisih_tahun_ini = abs($penghitungan_cuti_ini);
            $templateBA->setValue('sisa_tahun_1', $sisa_sebelumnya . '-' . $sisa_sebelumnya);
            $sisa_sekarang = $saldo_cuti->saldo_cuti_tahun_ini - abs($penghitungan_cuti_ini);
            $templateBA->setValue('sisa_tahun_0', $saldo_cuti->saldo_cuti_tahun_ini . '-' . abs($penghitungan_cuti_ini) . '=' . $sisa_sekarang);
            $templateBA->setValue('sisa_cuti_tahun_ini', 'Sisa ' . $sisa_sekarang . ' hari kerja');
            $catatan = 'Cuti tahun ' . $current_year_1 . ' dan tahun ' . $current_year . ' yang diambil tahun ' . $current_year . '-' . $data_cuti->alasan;
            $templateBA->setValue('catatan', $catatan);
        } else {
            $selisih_tahun_lalu = $hari_efektif_cuti_ini;
            $templateBA->setValue('sisa_tahun_1', $sisa_sebelumnya . '-' . $selisih_tahun_lalu);
            $templateBA->setValue('sisa_tahun_0', $saldo_cuti->saldo_cuti_tahun_ini);
        }


        $templateBA->setValue('tanggal_pengajuan', Carbon::parse($data_cuti->tgl_pengajuan)->isoFormat('D MMMM Y'));
        $templateBA->setValue('nomor_cuti', $data_cuti->nomor_surat_cuti);
        $templateBA->setValue('bulan_angka', $month_rome);
        $templateBA->setValue('tahun', $tahun);
        $templateBA->setValue('masa_kerja', $masa_kerja);

        $templateBA->setValue('nama_pegawai', $data_cuti->nama_pegawai);
        $templateBA->setValue('jabatan', $data_cuti->jabatan_pegawai);
        $templateBA->setValue('nip_pegawai', $data_cuti->nip_pegawai);
        $templateBA->setValue('cuti_tahunan', $data_cuti->id_jenis_cuti == 1 ? 'V' : '');
        $templateBA->setValue('cuti_sakit', $data_cuti->id_jenis_cuti == 2 ? 'V' : '');
        $templateBA->setValue('cuti_ap', $data_cuti->id_jenis_cuti == 4 ? 'V' : '');
        $templateBA->setValue('cuti_besar', $data_cuti->id_jenis_cuti == 5 ? 'V' : '');
        $templateBA->setValue('cuti_melahirkan', $data_cuti->id_jenis_cuti == 3 ? 'V' : '');
        $templateBA->setValue('cuti_ltn', $data_cuti->id_jenis_cuti == 6 ? 'V' : '');
        $templateBA->setValue('alasan', $data_cuti->alasan);
        $templateBA->setValue('tahun_0', $current_year);
        $templateBA->setValue('tahun_1', $current_year_1);
        $templateBA->setValue('tahun_2', $current_year_2);
        $templateBA->setValue('hari', $data_cuti->hari_efektif);
        $templateBA->setValue('tanggal_mulai', Carbon::parse($data_cuti->tgl_mulai)->format('d-m-Y'));
        $templateBA->setValue('tanggal_akhir', Carbon::parse($data_cuti->tgl_akhir)->format('d-m-Y'));
        $templateBA->setValue('alamat', $data_cuti->alamat_cuti);
        $templateBA->setValue('telepon', $data_cuti->nomor_hp);
        if (Str::contains($data_cuti->jabatan_pegawai, 'Hakim') || Str::contains($data_cuti->jabatan_pegawai, 'Wakil') || $data_cuti->jabatan_pegawai == 'Panitera' || $data_cuti->jabatan_pegawai == 'Sekretaris') {
            $templateBA->setValue('disetujui_ats', $data_cuti->acc_kpn ? 'V' : '');
            $templateBA->setValue('ditangguhkan_ats', $data_cuti->ditangguhkan_kpn ? 'V' : '');
            $templateBA->setValue('ditolak_ats', $data_cuti->reject_kpn ? 'V' : '');
        } else {
            $templateBA->setValue('disetujui_ats', $data_cuti->acc_ats ? 'V' : '');
            $templateBA->setValue('ditangguhkan_ats', $data_cuti->ditangguhkan_ats ? 'V' : '');
            $templateBA->setValue('ditolak_ats', $data_cuti->reject_ats ? 'V' : '');
        }

        $templateBA->setValue('disetujui_kpn', $data_cuti->acc_kpn ? 'V' : '');
        $templateBA->setValue('ditangguhkan_kpn', $data_cuti->ditangguhkan_kpn ? 'V' : '');
        $templateBA->setValue('ditolak_kpn', $data_cuti->reject_kpn ? 'V' : '');
        $templateBA->setValue('jabatan_atasan_langsung', $data_cuti->jabatan_atasan_langsung);
        $templateBA->setValue('nama_atasan_langsung', $data_cuti->nama_atasan);
        $templateBA->setValue('nip_atasan_langsung', $data_cuti->nip_atasan_langsung);
        $templateBA->setValue('nama_kpn', $kpn->nama);
        $templateBA->setValue('nip_kpn', $kpn->nip);
        // $templateBA->setValue('nip_pejabat', $data_pejabat['nip_pejabat']);

        // $templateBA->cloneRowAndSetValues('nomor', $data_fix);

        // $templateBA->setImageValue('qr', ['path' => ROOTPATH . 'public/qrcode_lemari/qrcode.png', 'width' => 200, 'height' => 200, 'ratio' => false]);
        header("Content-Disposition: attachment; filename=Form-cuti" . time() . ".docx");
        // $this->response->setContentType('application/vnd.openxmlformats-officedocument.wordprocessingml.document');
        // $this->response->setHeader('Content-Disposition', 'attachment;filename="Register-Permohonan' . time() . '.docx"');
        $pathToSave = 'php://output';
        $templateBA->saveAs($pathToSave);
    }

    public function modalNomorCuti(Request $request)
    {

        $id_leave = $request->id_leave;


        return response()->json(['modal' => view('leave.modal_nomor_cuti', ['id_leave' => $id_leave])->render()]);
    }

    public function insertNomorCuti(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'nomor_cuti' => 'required'
            ],
            [
                'nomor_cuti.required' => 'Nomor harus diisi'
            ]
        );

        if ($validator->fails()) {
            return redirect('leave')->withErrors($validator);
        }

        $validated = $validator->safe();
        $id_cuti = $request->id_cuti;

        DB::table('leaves')->where('id', $id_cuti)->update(['nomor_surat_cuti' => $validated['nomor_cuti']]);

        return redirect('leave')->with('success', 'Nomor cuti berhasil ditambahkan');
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

        return response()->json(['modal' => view('leave.modal_cetak_register', ['bulan' => $bulan, 'tahun' => $tahun_array])->render()]);
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
            return redirect('leave')
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
            $data = DB::table('leaves')->select('leaves.id as id_leave', 'leaves.*', 'employees.*', 'positions.*', 'units.*', 'leave_kinds.*', 'setuju_cuti.*')->leftJoin('employees', 'leaves.nip_pegawai', '=', 'employees.nip')->leftJoin('positions', 'employees.position_id', '=', 'positions.id')->leftJoin('units', 'employees.unit_id', '=', 'units.id')->leftJoin('leave_kinds', 'leaves.id_jenis_cuti', '=', 'leave_kinds.id')->leftJoin('setuju_cuti', 'leaves.id', '=', 'setuju_cuti.id_cuti')->whereMonth('tgl_pengajuan', $bulan)->whereYear('tgl_pengajuan', $tahun)->orderBy('tgl_pengajuan', 'asc')->get();
        }
        if (!$bulan) {
            $data = DB::table('leaves')->select('leaves.id as id_leave', 'leaves.*', 'employees.*', 'positions.*', 'units.*', 'leave_kinds.*', 'setuju_cuti.*')->leftJoin('employees', 'leaves.nip_pegawai', '=', 'employees.nip')->leftJoin('positions', 'employees.position_id', '=', 'positions.id')->leftJoin('units', 'employees.unit_id', '=', 'units.id')->leftJoin('leave_kinds', 'leaves.id_jenis_cuti', '=', 'leave_kinds.id')->leftJoin('setuju_cuti', 'leaves.id', '=', 'setuju_cuti.id_cuti')->whereYear('tgl_pengajuan', $tahun)->orderBy('tgl_pengajuan', 'asc')->get();
        }

        // dd($data);
        $data_cuti = [];
        foreach ($data as $d) {
            if ($d->acc_ats == null && $d->acc_kpn == null &&  $d->reject_ats == null && $d->reject_kpn == null && $d->ditangguhkan_ats == null && $d->ditangguhkan_kpn == null) {
                $status = 'Permohonan baru';
            }

            if ($d->acc_ats == "OK" && ($d->acc_kpn == "" || $d->acc_kpn == null) && ($d->reject_kpn == "" || $d->reject_kpn == null) && ($d->ditangguhkan_kpn == "" || $d->ditangguhkan_kpn == null)) {
                $status = 'Persetujuan Atasan Langsung';
            }
            if ($d->acc_kpn == "OK") {
                $status = 'Persetujuan KPN';
            }
            if ($d->reject_ats == "X") {
                $status = 'Ditolak Atasan Langsung';
            }
            if ($d->reject_kpn == "X") {
                $status = 'Ditolak KPN';
            }
            if ($d->ditangguhkan_ats == "X") {
                $status = 'Ditangguhkan Atasan Langsung';
            }
            if ($d->ditangguhkan_kpn == "X") {
                $status = 'Ditangguhkan KPN';
            }

            $data_cuti[] = ['tgl_pengajuan' => Carbon::parse($d->tgl_pengajuan)->format('d-m-Y'), 'nama' => $d->nama, 'tgl_mulai' => $d->tgl_mulai, 'tgl_akhir' => $d->tgl_akhir, 'jenis' => $d->jenis, 'status' => $status, 'hari_efektif' => $d->hari_efektif];
        }


        if ($bulan) {

            $pdf = PDF::loadView('leave.register', ["data" => $data_cuti, 'bulan' => $bulan_array[$bulan], 'tahun' => $tahun])->setPaper('a4', 'landscape');
        } else {
            $pdf = PDF::loadView('leave.register', ["data" => $data_cuti, 'tahun' => $tahun])->setPaper('a4', 'landscape');
        }

        return $pdf->download('register-cuti-' . $bulan . '-' . $tahun . '.pdf');
    }
}
