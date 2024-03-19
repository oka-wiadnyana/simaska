<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Salary;
use DataTables;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SalaryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function testQuery()
    {

        // $file = $this->request->getFile('file_checklist');
        // $file_name = "checklist_" . time() . "." . $file->guessExtension();
        // $file->move('raw_file', $file_name);
        # Create a new Xls Reader
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();

        // Tell the reader to only read the data. Ignore formatting etc.
        $reader->setReadDataOnly(true);

        // Read the spreadsheet file.
        // $spreadsheet = $reader->load(base_url('raw_file/ceklist.xlsx'));
        $spreadsheet = $reader->load(public_path('file_potongan_gaji/potongan_september_2023.xlsx'));

        $sheet = $spreadsheet->getSheet($spreadsheet->getFirstSheetIndex());
        $data = $sheet->toArray();
        // dd($data);

        // DB::table('klasifikasi_kka')->truncate();
        // dd($data);
        $affected = 0;
        foreach ($data as $key => $value) {
            if ($key == 0 || $key == 1) {
                continue;
            }

            $data_insert = [
                'nama' => $value[1],
                'gaji' => $value[2],
                'uang_makan' => $value[3],
                'remunerasi' => $value[4],
                'iuran_koperasi' => $value[5],
                'potongan_koperasi' => $value[6],
                'potongan_bri' => $value[7],
                'potongan_bpd' => $value[8],
                'potongan_ptwp' => $value[9],
                'bea_siswa' => $value[10],
                'ipaspi' => $value[11],
                'iuran_korpri' => $value[12],
                'dana_sosial' => $value[13],
                'simp_sukarela' => $value[14],
                'dana_punia' => $value[15],
                'yusti_karini' => $value[16],
                'sp_koperasi' => $value[17],
                'ydsh_ikahi' => $value[18],
                'lain_lain' => $value[21],
                'potongan_bank_gaji' => $value[22],
                'potongan_bank_remun' => $value[24],
                'bulan' => 10,
                'tahun' => 2023,

            ];

            // dd($data_insert);
            Salary::create($data_insert);
            $affected++;
        }


        echo "data berhasi diupdate";
    }

    // public function testQuery()
    // {
    //     // $data = Salary::select(DB::raw("(SELECT sum(gaji) + sum(uang_makan) + sum(remunerasi) from salaries group by bulan) as total"))->groupBy('bulan')->get();

    //     $d = DB::table('salaries as s')->select('bulan', 'tahun', DB::raw("(SELECT sum(gaji) + sum(uang_makan) + sum(remunerasi) from salaries where bulan=s.bulan) as total_gaji"), DB::raw("(SELECT sum(iuran_koperasi) + sum(potongan_koperasi) + sum(potongan_bri)+ sum(potongan_bpd)+ sum(potongan_ptwp)+ sum(bea_siswa)+ sum(ipaspi)+ sum(iuran_korpri)+ sum(dana_sosial)+ sum(simp_sukarela)+ sum(dana_punia)+ sum(yusti_karini)+ sum(sp_koperasi)+ sum(ydsh_ikahi)+ sum(lain_lain)+ sum(potongan_bank_gaji)+ sum(potongan_bank_remun) from salaries where bulan=s.bulan) as total_potongan"), DB::raw("(SELECT count(nama) from salaries where bulan=s.bulan) as total_pegawai"))->groupBy('bulan')->groupBy('tahun')->get();
    //     dd($d);
    // }

    public function index()
    {
        return view('salary.salary_list');
    }

    public function getSalaryData(Request $request)
    {
        if ($request->ajax()) {

            $data = Salary::where('nama', session('employee_name'))->orderBy('bulan', 'desc')->get();



            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('total_gaji', function ($row) {


                    $rawGaji = $row->gaji + $row->uang_makan + $row->remunerasi;
                    $totalGaji = 'Rp' . number_format($rawGaji, 2, ',', '.');

                    return $totalGaji;
                })
                ->addColumn('total_potongan', function ($row) {


                    $rawPotongan = $row->iuran_koperasi + $row->potongan_koperasi + $row->potongan_bri + $row->potongan_bpd + $row->potongan_ptwp + $row->bea_siswa + $row->ipaspi + $row->iuran_korpri + $row->dana_sosial + $row->simp_sukarela + $row->dana_punia + $row->yusti_karini + $row->sp_koperasi + $row->ydsh_ikahi + $row->lain_lain;
                    $totalPotongan = 'Rp' . number_format($rawPotongan, 2, ',', '.');
                    return $totalPotongan;
                })
                ->addColumn('sisa_gaji', function ($row) {


                    $rawGaji = $row->gaji + $row->uang_makan + $row->remunerasi;
                    $rawPotongan = $row->iuran_koperasi + $row->potongan_koperasi + $row->potongan_bri + $row->potongan_bpd + $row->potongan_ptwp + $row->bea_siswa + $row->ipaspi + $row->iuran_korpri + $row->dana_sosial + $row->simp_sukarela + $row->dana_punia + $row->yusti_karini + $row->sp_koperasi + $row->ydsh_ikahi + $row->lain_lain;
                    $rawSisa = $rawGaji - $rawPotongan;
                    $totalPotongan = 'Rp' . number_format($rawSisa, 2, ',', '.');
                    return $totalPotongan;
                })
                ->addColumn('bulan_full', function ($row) {


                    $bulan = Carbon::parse($row->tahun . '-' . $row->bulan . '-' . '01')->isoFormat('MMMM');
                    return $bulan;
                })
                ->addColumn('action', function ($row) {


                    $btn = '<a href="' . url('salary/get_slip/' . $row->bulan . '/' . $row->tahun) . '" class="btn btn-success" target="_blank">Lihat Slip</a>';
                    return $btn;
                })
                ->rawColumns(['total_gaji', 'total_potongan', 'sisa_gaji', 'action'])
                ->make(true);
        }
    }

    public function importExcel(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'bulan' => 'required',
            'tahun' => 'required',
            'file' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        Salary::where('bulan', $request->bulan)->where('tahun', $request->tahun)->delete();
        $file = $request->file('file');
        $file_name = time() . '.' . $file->getClientOriginalExtension();
        $file->storeAs('file_potongan_gaji', $file_name);

        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        // Tell the reader to only read the data. Ignore formatting etc.
        $reader->setReadDataOnly(true);

        // Read the spreadsheet file.
        // $spreadsheet = $reader->load(base_url('raw_file/ceklist.xlsx'));
        $spreadsheet = $reader->load(new \Illuminate\Http\File(base_path('storage/app/file_potongan_gaji/' . $file_name)));

        $sheet = $spreadsheet->getSheet($spreadsheet->getFirstSheetIndex());
        $data = $sheet->toArray();


        $affected = 0;
        foreach ($data as $key => $value) {
            if ($key == 0 || $key == 1) {
                continue;
            }

            $data_insert = [
                'nama' => $value[1],
                'gaji' => $value[2],
                'uang_makan' => $value[3],
                'remunerasi' => $value[4],
                'iuran_koperasi' => $value[5],
                'potongan_koperasi' => $value[6],
                'potongan_bri' => $value[7],
                'potongan_bpd' => $value[8],
                'potongan_ptwp' => $value[9],
                'bea_siswa' => $value[10],
                'ipaspi' => $value[11],
                'iuran_korpri' => $value[12],
                'dana_sosial' => $value[13],
                'simp_sukarela' => $value[14],
                'dana_punia' => $value[15],
                'yusti_karini' => $value[16],
                'sp_koperasi' => $value[17],
                'ydsh_ikahi' => $value[18],
                'lain_lain' => $value[21],
                'potongan_bank_gaji' => $value[22],
                'potongan_bank_remun' => $value[24],
                'bulan' => $request->bulan,
                'tahun' => $request->tahun,

            ];

            // dd($data_insert);
            Salary::create($data_insert);
            $affected++;
        }

        try {
            $now = Carbon::now()->setTimeZone('Asia/Makassar');

            $hour = $now->hour;
            $time = $hour >= 6 && $hour < 14 ? 'Selamat pagi' : ($hour >= 14 && $hour < 18 ? 'Selamat sore' : 'Selamat malam');
            $pesan = urlencode("$time Bapak Ibu, slip gaji bulan $request->bulan $request->tahun telah diupload pada aplikasi SiKreta, silahkan diakses melalui akun Sikreta masing-masing");

            Http::get("http://websocket.onsdeeapp.my.id:4141/sikreta/$pesan");
        } catch (\Exception $e) {
        }

        return redirect()->back()->with('success', $affected . ' data berhasil diinput');
    }

    public function importSalary(Request $request)
    {

        return response()->json(['modal' => view('salary.modal_import')->render()]);
    }

    public function slipGaji($bulan = null, $tahun = null, $nama = null)
    {
        if ($nama == null) {

            $data_gaji = Salary::where('nama', session('employee_name'))->where('bulan', $bulan)->where('tahun', $tahun)->first();
        } else {
            $data_gaji = Salary::where('nama', $nama)->where('bulan', $bulan)->where('tahun', $tahun)->first();
        }
        $total_gaji = $data_gaji->gaji + $data_gaji->uang_makan + $data_gaji->remunerasi;
        $totalPotongan = $data_gaji->iuran_koperasi + $data_gaji->potongan_koperasi + $data_gaji->potongan_bri + $data_gaji->potongan_bpd + $data_gaji->potongan_ptwp + $data_gaji->bea_siswa + $data_gaji->ipaspi + $data_gaji->iuran_korpri + $data_gaji->dana_sosial + $data_gaji->simp_sukarela + $data_gaji->dana_punia + $data_gaji->yusti_karini + $data_gaji->sp_koperasi + $data_gaji->ydsh_ikahi + $data_gaji->lain_lain;

        $sisa = $total_gaji - $totalPotongan;

        return view('salary.slip_gaji', ['data' => $data_gaji, 'total_gaji' => $total_gaji, 'total_potongan' => $totalPotongan, 'sisa' => $sisa, 'potongan_gaji' => $data_gaji->potongan_bank_gaji, 'potongan_remun' => $data_gaji->potongan_bank_remun]);
    }

    public function adminList()
    {
        return view('salary.admin_list');
    }

    public function getSalaryAdmin(Request $request)
    {
        if ($request->ajax()) {


            $data = DB::table('salaries as s')->select('bulan', 'tahun', DB::raw("(SELECT sum(gaji) + sum(uang_makan) + sum(remunerasi) from salaries where bulan=s.bulan) as total_gaji"), DB::raw("(SELECT sum(iuran_koperasi) + sum(potongan_koperasi) + sum(potongan_bri)+ sum(potongan_bpd)+ sum(potongan_ptwp)+ sum(bea_siswa)+ sum(ipaspi)+ sum(iuran_korpri)+ sum(dana_sosial)+ sum(simp_sukarela)+ sum(dana_punia)+ sum(yusti_karini)+ sum(sp_koperasi)+ sum(ydsh_ikahi)+ sum(lain_lain) from salaries where bulan=s.bulan) as total_potongan"), DB::raw("(SELECT count(nama) from salaries where bulan=s.bulan) as total_pegawai"))->groupBy('bulan')->groupBy('tahun')->orderByDesc('tahun')->orderByDesc('bulan')->get();



            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('total_gaji', function ($row) {



                    $totalGaji = 'Rp' . number_format($row->total_gaji, 2, ',', '.');

                    return $totalGaji;
                })
                ->addColumn('total_potongan', function ($row) {


                    $totalPotongan = 'Rp' . number_format($row->total_potongan, 2, ',', '.');
                    return $totalPotongan;
                })


                ->addColumn('bulan_full', function ($row) {


                    $bulan = Carbon::parse($row->tahun . '-' . $row->bulan . '-' . '01')->isoFormat('MMMM');
                    return $bulan;
                })
                ->addColumn('action', function ($row) {


                    $btn = '<a href="' . url('salary/delete_admin/' . $row->bulan . '/' . $row->tahun) . '" class="btn btn-danger" >Delete</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function deleteAdmin($bulan, $tahun)
    {
        Salary::where('bulan', $bulan)->where('tahun', $tahun)->delete();
        return redirect()->back();
    }

    public function slipUmum()
    {
        return view('salary.slip_umum');
    }

    public function getSalaryUmum(Request $request)
    {
        $bulan = $request->bulan ?? date('m');
        $tahun = $request->tahun ?? date('Y');


        $data = Salary::where('bulan', $bulan)->where('tahun', $tahun)->get();

        $data_gaji = [];
        foreach ($data as $d) {
            $rawGaji = $d->gaji + $d->uang_makan + $d->remunerasi;
            $totalGaji = 'Rp' . number_format($rawGaji, 2, ',', '.');

            $rawPotongan = $d->iuran_koperasi + $d->potongan_koperasi + $d->potongan_bri + $d->potongan_bpd + $d->potongan_ptwp + $d->bea_siswa + $d->ipaspi + $d->iuran_korpri + $d->dana_sosial + $d->simp_sukarela + $d->dana_punia + $d->yusti_karini + $d->sp_koperasi + $d->ydsh_ikahi + $d->lain_lain;
            $totalPotongan = 'Rp' . number_format($rawPotongan, 2, ',', '.');

            $rawSisa = $rawGaji - $rawPotongan;
            $totalSisa = 'Rp' . number_format($rawSisa, 2, ',', '.');

            $bulan_long = Carbon::parse($d->tahun . '-' . $d->bulan . '-' . '01')->isoFormat('MMMM');

            $data_gaji[] = ['id' => $d->id, 'nama' => $d->nama, 'bulan' => $bulan_long, 'tahun' => $tahun, 'total_gaji' => $totalGaji, 'total_potongan' => $totalPotongan, 'sisa' => $totalSisa];
        }


        return response()->json([view('salary.table_slip_umum', ['data' => $data_gaji, 'bulan' => $bulan, 'tahun' => $tahun])->render()]);
    }
}
