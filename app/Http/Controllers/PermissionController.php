<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use DataTables;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpWord\TemplateProcessor;
use Illuminate\Support\Carbon;
use PDF;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Query\Builder;

class PermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {

        return view('permission.permission_list', ['umum' => true]);

        //
    }

    public function pribadi(Request $request)
    {

        return view('permission.permission_list');

        //
    }


    public function getPermission(Request $request, $nip = null)
    {

        if ($nip == null) {

            $data = DB::table('izin_keluar_kantor as a')->select('a.id as id_permission', 'b.nama as nama_pegawai', 'e.nama as nama_atasan', 'a.*', 'b.*', 'c.*', 'd.*')->leftJoin('employees as b', 'a.nip', '=', 'b.nip')->leftJoin('positions as c', 'b.position_id', '=', 'c.id')->leftJoin('units as d', 'b.unit_id', '=', 'd.id')->leftJoin('employees as e', 'a.nip_atasan', '=', 'e.nip')->orderBy('tanggal', 'desc')->get();
        }
        if ($nip != null) {
            $data = DB::table('izin_keluar_kantor as a')->select('a.id as id_permission', 'b.nama as nama_pegawai', 'e.nama as nama_atasan', 'a.*', 'b.*', 'c.*', 'd.*')->leftJoin('employees as b', 'a.nip', '=', 'b.nip')->leftJoin('positions as c', 'b.position_id', '=', 'c.id')->leftJoin('units as d', 'b.unit_id', '=', 'd.id')->leftJoin('employees as e', 'a.nip_atasan', '=', 'e.nip')->orderBy('tanggal', 'desc')->where('a.nip', $nip)->get();
        }

        return Datatables::of($data)
            ->addIndexColumn()

            ->addColumn('pukul', function ($row) {


                $pukul = $row->jam_awal . ' s.d ' . $row->jam_akhir;

                return $pukul;
            })
            ->addColumn('action', function ($row) {


                if (session('kepegawaian')==true) {
                    $actionBtn = '<a href="" class="edit-btn btn-success btn-sm" data-id="' . $row->id_permission . '">Edit</a> <a href="" class="delete-btn btn-danger btn-sm"data-id="' . $row->id_permission . '">Delete</a> ';
                    if ($row->acc_ats == 'Y') {
                        $actionBtn .= '<a href="' . url('permission/cetak_form/' . $row->id_permission) . '" class="cetak-form-btn btn-info btn-sm"data-id="' . $row->id_permission . '" target="_blank">Cetak</a>';
                    }
                } else {
                    $actionBtn = '<a href="" class="edit-btn btn-success btn-sm" data-id="' . $row->id_permission . '">Edit</a>';
                }

                return $actionBtn;
            })
            ->addColumn('status', function ($row) {


                if ($row->acc_ats == 'Y') {
                    $status = 'Persetujuan atasan';
                }

                if ($row->reject_ats == 'Y') {
                    $status = 'Ditolak atasan';
                }

                if (!$row->acc_ats && !$row->reject_ats) {
                    $status = 'Permohonan baru';
                }

                return $status;
            })
            ->rawColumns(['action', 'pukul', 'status'])
            ->make(true);
    }


    public function modalInsert(Request $request, $jenis = null)
    {

        $pegawai = DB::table('employees')->get();

        return response()->json(['modal' => view('permission.modal_tambah', ['pegawai' => $pegawai, 'jenis' => $jenis])->render()]);
    }

    public function insert(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'tanggal' => 'required',
                'jam_awal' => 'required',
                'jam_akhir' => 'required',
                'nip' => 'required',
                'nip_atasan' => 'required',
                'alasan' => 'required'
            ],
            [
                'tanggal.required' => 'Tanggal harus diisi',
                'jam_awal.required' => 'Jam Awal harus diisi',
                'jam_akhir.required' => 'Jam Akhir harus diisi',
                'nip.required' => 'NIP harus diisi',
                'nip_atasan.required' => 'NIP Atasan harus diisi',
                'alasan.required' => 'Alasan harus diisi',
            ]

        );


        if ($validator->fails()) {
            return redirect('permission')->withErrors($validator);
        }

        $dataInsert = $validator->safe();

        DB::table('izin_keluar_kantor')->updateOrInsert(
            ['id' => $request->id],
            ['tanggal' => $dataInsert['tanggal'], 'jam_awal' => $dataInsert['jam_awal'], 'jam_akhir' => $dataInsert['jam_akhir'], 'nip' => $dataInsert['nip'], 'nip_atasan' => $dataInsert['nip_atasan'], 'alasan' => $dataInsert['alasan']]
        );
        if ($request->jenis == 'umum') {

            return redirect('permission')->with('success', 'Data berhasil diinput');
        } else {
            return redirect('permission/pribadi')->with('success', 'Data berhasil diinput');
        }
    }

    public function modalEdit(Request $request)
    {
        $id = $request->id_permission;
        $dataIzin = DB::table('izin_keluar_kantor as a')->select('a.id as id_permission', 'b.nama as nama_pegawai', 'e.nama as nama_atasan', 'a.*', 'b.*', 'c.*', 'd.*')->leftJoin('employees as b', 'a.nip', '=', 'b.nip')->leftJoin('positions as c', 'b.position_id', '=', 'c.id')->leftJoin('units as d', 'b.unit_id', '=', 'd.id')->leftJoin('employees as e', 'a.nip_atasan', '=', 'e.nip')->where('a.id', $id)->first();
        $pegawai = DB::table('employees')->get();


        return response()->json(['modal' => view('permission.modal_edit', ['pegawai' => $pegawai, 'data' => $dataIzin])->render()]);
    }

    public function delete(Request $request)
    {
        $id = $request->id;
        DB::table('izin_keluar_kantor')->delete($id);
        session('success', 'Data berhasil dihapus');
        return response()->json(['msg' => 'success']);
    }

    public function cetak_form(Request $request, $id = null)
    {
        $data_permission = DB::table('izin_keluar_kantor as a')->select('b.nama as nama_pegawai', 'c.nama as nama_atasan', 'b.nip as nip_pegawai', 'c.nip as nip_atasan', 'e.nama_jabatan as jabatan_pegawai', 'd.nama_jabatan as jabatan_atasan', 'a.*', 'b.*', 'c.*', 'd.*')->leftJoin('employees as b', 'a.nip', '=', 'b.nip')->leftJoin('employees as c', 'a.nip_atasan', '=', 'c.nip')->leftJoin('positions as d', 'c.position_id', '=', 'd.id')->leftJoin('positions as e', 'b.position_id', '=', 'e.id')->where('a.id', $id)->first();
        // dd($data_permission);

        if ($data_permission->jabatan_pegawai == 'Hakim' || $data_permission->jabatan_pegawai == 'Ketua' || $data_permission->jabatan_pegawai == 'Wakil Ketua') {

            $templateBA = new TemplateProcessor(asset('template_cuti/Form-keluar-kantor-pegawai.docx'));
        } else {
            $templateBA = new TemplateProcessor(asset('template_cuti/Form-keluar-kantor-pegawai.docx'));
        }

        // dd($data_permission);
        $templateBA->setValue('nama_atasan', $data_permission->nama_atasan);
        $templateBA->setValue('nip_atasan', $data_permission->nip_atasan);
        $templateBA->setValue('jabatan_atasan', $data_permission->jabatan_atasan);
        $templateBA->setValue('nama_pegawai', $data_permission->nama_pegawai);
        $templateBA->setValue('nip_pegawai', $data_permission->nip_pegawai);
        $templateBA->setValue('hari', Carbon::parse($data_permission->tanggal)->isoFormat('dddd'));
        $templateBA->setValue('tanggal', Carbon::parse($data_permission->tanggal)->isoFormat('D MMMM Y'));
        $templateBA->setValue('jam_awal', $data_permission->jam_awal);
        $templateBA->setValue('jam_akhir', $data_permission->jam_akhir);
        $templateBA->setValue('keperluan', $data_permission->alasan);

        // $templateBA->setValue('nip_pejabat', $data_pejabat['nip_pejabat']);

        // $templateBA->cloneRowAndSetValues('nomor', $data_fix);

        // $templateBA->setImageValue('qr', ['path' => ROOTPATH . 'public/qrcode_lemari/qrcode.png', 'width' => 200, 'height' => 200, 'ratio' => false]);
        header("Content-Disposition: attachment; filename=Form-keluar-kantor" . time() . ".docx");
        // $this->response->setContentType('application/vnd.openxmlformats-officedocument.wordprocessingml.document');
        // $this->response->setHeader('Content-Disposition', 'attachment;filename="Register-Permohonan' . time() . '.docx"');
        $pathToSave = 'php://output';
        $templateBA->saveAs($pathToSave);
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

        return response()->json(['modal' => view('permission.modal_cetak_register', ['bulan' => $bulan, 'tahun' => $tahun_array])->render()]);
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
            $data = DB::table('izin_keluar_kantor as a')->select('a.id as id_permission', 'b.nama as nama_pegawai', 'e.nama as nama_atasan', 'a.*', 'b.*', 'c.*', 'd.*')->leftJoin('employees as b', 'a.nip', '=', 'b.nip')->leftJoin('positions as c', 'b.position_id', '=', 'c.id')->leftJoin('units as d', 'b.unit_id', '=', 'd.id')->leftJoin('employees as e', 'a.nip_atasan', '=', 'e.nip')->orderBy('tanggal', 'desc')->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun)->orderBy('tanggal', 'asc')->get();
        }
        if (!$bulan) {
            $data = DB::table('izin_keluar_kantor as a')->select('a.id as id_permission', 'b.nama as nama_pegawai', 'e.nama as nama_atasan', 'a.*', 'b.*', 'c.*', 'd.*')->leftJoin('employees as b', 'a.nip', '=', 'b.nip')->leftJoin('positions as c', 'b.position_id', '=', 'c.id')->leftJoin('units as d', 'b.unit_id', '=', 'd.id')->leftJoin('employees as e', 'a.nip_atasan', '=', 'e.nip')->orderBy('tanggal', 'desc')->whereYear('tanggal', $tahun)->orderBy('tanggal', 'asc')->get();
        }



        if ($bulan) {

            $pdf = PDF::loadView('permission.register', ["data" => $data, 'bulan' => $bulan_array[$bulan], 'tahun' => $tahun])->setPaper('a4', 'landscape');
        } else {
            $pdf = PDF::loadView('permission.register', ["data" => $data, 'tahun' => $tahun])->setPaper('a4', 'landscape');
        }

        return $pdf->download('register-cuti-' . $bulan . '-' . $tahun . '.pdf');
    }

    public function permohonan(Request $request)
    {
        return view('permission/permohonan_list');
    }

    public function getDataPermohonan()
    {

        $nip_atasan = session('employee_nip');
        $data = DB::table('izin_keluar_kantor as a')->select('a.id as id_permission', 'b.nama as nama_pegawai', 'e.nip as nip_atasan', 'a.*', 'b.*', 'c.*', 'd.*')->leftJoin('employees as b', 'a.nip', '=', 'b.nip')->leftJoin('positions as c', 'b.position_id', '=', 'c.id')->leftJoin('units as d', 'b.unit_id', '=', 'd.id')->leftJoin('employees as e', 'a.nip_atasan', '=', 'e.nip')->where('e.nip', $nip_atasan)->orderBy('tanggal', 'desc')->get();


        return Datatables::of($data)
            ->addIndexColumn()

            ->addColumn('pukul', function ($row) {


                $pukul = $row->jam_awal . ' s.d ' . $row->jam_akhir;

                return $pukul;
            })
            ->addColumn('action', function ($row) {


                if (!$row->acc_ats && !$row->reject_ats) {
                    $actionBtn = '<a href="" class="setuju-btn btn-success btn-sm" data-id="' . $row->id_permission . '">Setuju</a> <a href="" class="tolak-btn btn-danger btn-sm"data-id="' . $row->id_permission . '">Tolak</a>';
                } else {
                    $actionBtn = "";
                }

                return $actionBtn;
            })
            ->addColumn('status', function ($row) {


                if ($row->acc_ats == 'Y') {
                    $status = 'Persetujuan atasan';
                }

                if ($row->reject_ats == 'Y') {
                    $status = 'Ditolak atasan';
                }

                if (!$row->acc_ats && !$row->reject_ats) {
                    $status = 'Permohonan baru';
                }

                return $status;
            })
            ->rawColumns(['action', 'pukul', 'status'])
            ->make(true);
    }

    public function setuju(Request $request)
    {
        $id = $request->id;

        DB::table('izin_keluar_kantor')->where('id', $id)->update(['acc_ats' => 'Y']);

        return response()->json(['msg' => 'success']);
    }

    public function tolak(Request $request)
    {
        $id = $request->id;

        DB::table('izin_keluar_kantor')->where('id', $id)->update(['reject_ats' => 'Y']);

        return response()->json(['msg' => 'success']);
    }

    public function notifikasi(Request $request): JsonResponse
    {

        $nip_atasan = session('employee_nip');
        $data_belum_ditanggapi = DB::table('izin_keluar_kantor as a')->select('a.id as id_permission', 'b.nama as nama_pegawai', 'e.nip as nip_atasan', 'a.*', 'b.*', 'c.*', 'd.*')->leftJoin('employees as b', 'a.nip', '=', 'b.nip')->leftJoin('positions as c', 'b.position_id', '=', 'c.id')->leftJoin('units as d', 'b.unit_id', '=', 'd.id')->leftJoin('employees as e', 'a.nip_atasan', '=', 'e.nip')->where('e.nip', $nip_atasan)->where(function (Builder $query) {
            $query->where('acc_ats', null)
                ->where('reject_ats', null);
        })->orderBy('tanggal', 'desc')->count();
        return response()->json(['jml' => $data_belum_ditanggapi]);
    }
}
