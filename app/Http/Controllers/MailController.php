<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use DataTables;
use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use PDF;
use Illuminate\Support\Arr;
use PhpOffice\PhpWord\TemplateProcessor;

class MailController extends Controller
{
    /**
     * Show the profile for the given user.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */

    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request, $signer,$id = null,)
    {
        return view('mail.mail_list',['signer'=>$signer]);

        //
    }

    public function getMailsData(Request $request,$signer)
    {
        if ($request->ajax()) {
            if ((session('renprog') == true || session('kepegawaian') == true  ||session('tu_rt') == true || session('keuangan') == true )) {

                $data = DB::table('mails')->select('mails.id as id_surat', 'mails.*', 'employees.*', 'positions.*', 'units.*')->leftJoin('employees', 'mails.employee_id', '=', 'employees.id')->leftJoin('positions', 'employees.position_id', '=', 'positions.id')->leftJoin('units', 'employees.unit_id', '=', 'units.id')->orderBy('tanggal_surat', 'desc')->orderBy('nomor_index', 'desc')->where('penanda_tangan',$signer)->get();
            } else {
                $data = DB::table('mails')->where('mails.bagian', session('employee_unit'))->select('mails.id as id_surat', 'mails.*', 'employees.*', 'positions.*', 'units.*')->leftJoin('employees', 'mails.employee_id', '=', 'employees.id')->leftJoin('positions', 'employees.position_id', '=', 'positions.id')->leftJoin('units', 'employees.unit_id', '=', 'units.id')->orderBy('tanggal_surat', 'desc')->orderBy('nomor_index', 'desc')->where('penanda_tangan',$signer)->get();
            }
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('file_formating', function ($row) {

                    if ($row->file == null || $row->file == "") {
                        $file_btn = '<a href="" class="upload-btn btn-warning btn-sm" data-id="' . $row->id_surat . '">Upload</a>';
                    } else {
                        $file_btn = '<a href="/downloadsurat/' . $row->file . '" class="download-btn btn-primary btn-sm" data-id="' . $row->id_surat . '" target="_blank">Download</a> <a href="" class="upload-btn btn-warning btn-sm" data-id="' . $row->id_surat . '" data-update="update">Upload</a>';
                    }

                    return $file_btn;
                })
                ->addColumn('arsip', function ($row) {

                    if ($row->arsip == null || $row->arsip == "") {
                        $arsip = "<i class='h1 bx bxs-minus-circle text-danger'></i>";
                    }
                    if ($row->arsip != null && $row->file != null) {
                        $arsip = '<i class="h1 bx bxs-check-circle text-success"></i> <br> (Uploaded)';
                    }

                    if ($row->arsip != null && $row->file == null) {
                        $arsip = '<i class="h1 bx bxs-check-circle text-success"></i> <br> (Hardcopy)';
                    }

                    return $arsip;
                })

                ->addColumn('action', function ($row) {
                    if ((session('tu_rt') == true)) {

                        $arsipBtn = $row->arsip != 'Y' ? '<a href="" class="arsip-btn btn-info btn-sm"data-id="' . $row->id_surat . '">Arsip</a>' : '';
                        $actionBtn = '<a href="" class="edit-btn btn-success btn-sm" data-id="' . $row->id_surat . '">Edit</a> <a href="" class="delete-btn btn-danger btn-sm"data-id="' . $row->id_surat . '">Delete</a> <a href="" class="cetak-btn btn-primary btn-sm" data-id="' . $row->id_surat . '">Cetak</a>' . $arsipBtn;
                    } else {
                        $actionBtn = '<a href="" class="edit-btn btn-success btn-sm" data-id="' . $row->id_surat . '">Edit</a>';
                    }
                    return $actionBtn;
                })
                ->rawColumns(['file_formating', 'arsip', 'action'])
                ->make(true);
        }
    }

    public function modalTambahSurat(Request $request,$signer)
    {
        date_default_timezone_set('Asia/Bangkok');
        $now = date('Y-m-d');
        $pegawai = DB::table('employees')->get();
        $bagian = DB::table('units')->get();
        $klasifikasi = DB::table('klasifikasi_kka')->get();
        return response()->json(['modal' => view('mail.modal_tambah_surat', ['now' => $now, 'pegawai' => $pegawai, 'bagian' => $bagian, 'klasifikasi' => $klasifikasi,'signer'=>$signer])->render()]);
    }

    public function tambahSurat(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                
                'kode_surat' => 'required',
                'tanggal_surat' => 'required',
                'perihal' => 'required',
                'tujuan' => 'required',
                'employee_id' => 'required',

            ],

            [
               
                'kode_surat.required' => 'Kode surat harus diisi',
                'tanggal_surat.required' => 'Tanggal surat harus diisi',
                'perihal.required' => 'Perihal surat harus diisi',
                'tujuan.required' => 'Tujuan surat harus diisi',
                'employee_id.required' => 'Pegawai harus diisi'
            ]
        );

        if ($validator->fails()) {
            return redirect('mails/'.$request->signer)
                ->withErrors($validator)
                ->withInput();
            // dd($validator);
        }
        $nomor_manual = $request->input('nomor_manual');
        $bagian_manual = $request->input('bagian_manual');
        $employee_id = $request->input('employee_id');
        $penandatangan_surat = $request->input('signer');
        $kode_surat = $request->input('kode_surat');
        $tanggal_surat = $request->input('tanggal_surat');
        $perihal = $request->input('perihal');
        $tujuan = $request->input('tujuan');
        $array_tanggal = explode('-', $tanggal_surat);
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

        $penandatangan=$penandatangan_surat=='kpt'?'KPT':($penandatangan_surat=='pan'?'PAN.PT':'SEK.PT');
        if ($nomor_manual) {
            $regexVal="/^(?=.*[0-9])(?=.*[a-zA-Z])[^.]*$/i";
            // dd(preg_match($regexVal,$nomor_manual));
            if(preg_match($regexVal,$nomor_manual)){
                return back()->with('fail','Isikan titik (.) diantara huruf dan angka');
            }

            $is_continue = explode('.', $nomor_manual);
            if (count($is_continue) == 1) {

                $new_number = $is_continue[0];
            }
            if (count($is_continue) > 1) {

                $new_number = 0;
            }
            
            $nomor_surat = $nomor_manual . '/' . $penandatangan . '.' . $kode_wilayah . '/' . $kode_surat . '/' . $month_rome . '/' . $tahun;
        } else {
            $max_nomor = DB::table('mails')->whereYear('tanggal_surat', $tahun)->where('penanda_tangan',$penandatangan_surat)->max('nomor_index');
            if ($max_nomor) {

                $new_number = $max_nomor + 1;
            }

            if (!$max_nomor || $max_nomor == 0) {
                $new_number = 1;
            }
            $nomor_surat = $new_number . '/' . $penandatangan . '.' . $kode_wilayah . '/' . $kode_surat . '/' . $month_rome . '/' . $tahun;
        }

        if (DB::table('mails')->insert([
            'nomor_index' => $new_number,
            'nomor_surat' => $nomor_surat,
            'tanggal_surat' => $tanggal_surat,
            'penanda_tangan'=>$penandatangan_surat,
            'perihal' => $perihal,
            'tujuan' => $tujuan,
            'employee_id' => $employee_id,
            'bagian' => $bagian_manual ?? session('employee_unit')

        ])) {
            return redirect('mails/'.$penandatangan_surat)->with('success', 'Data berhasil diinput');
        }
    }

    public function modalEdit(Request $request,$signer)
    {
        $id_surat = $request->input('id_surat');
        $data_surat = DB::table('mails')->find($id_surat);
        $kode_surat = explode('/', $data_surat->nomor_surat)[2];
        $pegawai = DB::table('employees')->get();
        return response()->json(['modal' => view('mail.modal_edit_surat', ['data' => $data_surat, 'kode_surat' => $kode_surat, 'pegawai' => $pegawai,'signer'=>$signer])->render()]);
    }

    public function editSurat(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [

                'tanggal_surat' => 'required',
                'perihal' => 'required',
                'tujuan' => 'required',
                'employee_id' => 'required',
                'kode_surat' => 'required',

            ],

            [

                'tanggal_surat.required' => 'Tanggal surat harus diisi',
                'perihal.required' => 'Perihal surat harus diisi',
                'tujuan.required' => 'Tujuan surat harus diisi',
                'employee_id.required' => 'Pegawai surat harus diisi',
                'kode_surat.required' => 'Kode surat harus diisi'
            ]
        );

        if ($validator->fails()) {
            return redirect('mails/'.$request->signer)
                ->withErrors($validator)
                ->withInput();
        }


        $id_surat = $request->input('id_surat');
        $tanggal_surat = $request->input('tanggal_surat');
        $perihal = $request->input('perihal');
        $employee_id = $request->input('employee_id');
        $tujuan = $request->input('tujuan');
        $kode_surat = $request->input('kode_surat');

        $data_surat = DB::table('mails')->where('id', $id_surat)->first();
        $nomor_surat = explode('/', $data_surat->nomor_surat);
        $nomor_baru = $nomor_surat[0] . '/' . $nomor_surat[1] . '/' . $kode_surat . '/' . $nomor_surat[3] . '/' . $nomor_surat[4];
        if (DB::table('mails')->where('id', $id_surat)->update([

            'tanggal_surat' => $tanggal_surat,
            'perihal' => $perihal,
            'tujuan' => $tujuan,
            'employee_id' => $employee_id,
            'nomor_surat' => $nomor_baru,

        ])) {
            return redirect('mails/'.$request->signer)->with('success', 'Data berhasil diubah');
        }
    }


    public function modalupload(Request $request)
    {
        $id_surat = $request->input('id_surat');
        $data_update = $request->input('data_update');
        $data_surat = DB::table('mails')->find($id_surat);
        return response()->json(['modal' => view('mail.modal_upload_file', ['data' => $data_surat, 'data_update' => $data_update])->render()]);
    }

    public function uploadSurat(Request $request)
    {
        $file_surat = $request->file('file_surat');
        $id_surat = $request->input('id_surat');
        $data_surat = DB::table('mails')->find($id_surat);
        $validator = Validator::make(
            $request->all(),
            [

                'file_surat' => 'required|mimes:pdf,jpg,jpeg',

            ],

            [

                'file_surat.required' => 'File surat harus diupload',
                'file_surat.mimes' => 'Jenis file salah',
            ]
        );
        if ($validator->fails()) {
            return redirect('mails/'.$data_surat->penanda_tangan)
                ->withErrors($validator)
                ->withInput();
        }

        $data_surat = DB::table('mails')->find($id_surat);
        // if ($data_surat->file) {
        //     unlink(public_path('file_surat/' . $data_surat->file));
        // }

        $nama_file = explode('/', $data_surat->nomor_surat);
        $nama_file = implode('.', $nama_file);
        $nama_file = $nama_file . '.' . $file_surat->getClientOriginalExtension();

        if ($request->input('data_update')) {

            $file_surat->move('file_surat', $nama_file);
            return redirect('mails')->with('success', 'File berhasil diupload');
        }
        $file_surat->move('file_surat', $nama_file);

        if (DB::table('mails')->where('id', $id_surat)->update([
            'file' => $nama_file, 'arsip' => 'Y'
        ])) {
            return redirect('mails/'.$data_surat->penanda_tangan)->with('success', 'File berhasil diupload');
        } else {
            return redirect('mails/'.$data_surat->penanda_tangan)->with('fail', 'File gagal diupload');
        }
    }

    public function downloadSurat(Request $request)
    {
        $nama_file = $request->segment(2);
        $filePath = public_path("file_surat/" . $nama_file);
        return response()->download($filePath);
    }

    public function hapusSurat(Request $request)
    {
        $id_surat = $request->input('id_surat');
        if (DB::table('mails')->where('id', $id_surat)->delete()) {
            $request->session()->flash('success', 'Data berhasil dihapus!');

            return response()->json(['success']);
        }
    }

    public function modalCetakRegister($signer)
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

        return response()->json(['modal' => view('mail.modal_cetak_register', ['bulan' => $bulan, 'tahun' => $tahun_array,'signer'=>$signer])->render()]);
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
        $signer=$request->signer;
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
            $data_surat = DB::table('mails')->whereMonth('tanggal_surat', $bulan)->whereYear('tanggal_surat', $tahun)->where('penanda_tangan',$signer)->leftJoin('employees', 'mails.employee_id', '=', 'employees.id')->leftJoin('positions', 'employees.position_id', '=', 'positions.id')->leftJoin('units', 'employees.unit_id', '=', 'units.id')->orderBy('tanggal_surat', 'desc')->orderBy('nomor_surat')->get();
            // dd($signer,$bulan,$tahun,$data_surat);
            $pdf = PDF::loadView('mail.register', ["surat" => $data_surat, 'bulan' => $bulan_array[$bulan], 'tahun' => $tahun,'signer'=>$signer])->setPaper([0, 0, 595.276, 935.433], 'landscape');
        }
        if (!$bulan) {
            $data_surat = DB::table('mails')->whereYear('tanggal_surat', $tahun)->leftJoin('employees', 'mails.employee_id', '=', 'employees.id')->leftJoin('positions', 'employees.position_id', '=', 'positions.id')->leftJoin('units', 'employees.unit_id', '=', 'units.id')->orderBy('tanggal_surat', 'desc')->orderBy('nomor_surat')->get();
            $pdf = PDF::loadView('mail.register', ["surat" => $data_surat,  'tahun' => $tahun])->setPaper([0, 0, 595.276, 935.433], 'landscape');
        }



        return $pdf->download('register-' . $bulan . '-' . $tahun . '.pdf');
    }

    public function modalCetakRegisterHarian($signer)
    {
        
        return response()->json(['modal' => view('mail.modal_cetak_register_harian', ['signer'=>$signer])->render()]);
    }
    public function cetakRegisterHarian(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [

                'tanggal' => 'required',


            ],

            [

                'tanggal.required' => 'Tanggal harus diisi',

            ]
        );

        if ($validator->fails()) {
            return redirect('mails/'.$request->signer)
                ->withErrors($validator)
                ->withInput();
        }


        $tanggal = $request->tanggal;
     
        $signer=$request->signer;
        
       
            $data_surat = DB::table('mails')->where('tanggal_surat', $tanggal)->where('penanda_tangan', $signer)->leftJoin('employees', 'mails.employee_id', '=', 'employees.id')->leftJoin('positions', 'employees.position_id', '=', 'positions.id')->leftJoin('units', 'employees.unit_id', '=', 'units.id')->orderBy('tanggal_surat', 'desc')->orderBy('nomor_surat')->get();
            $pdf = PDF::loadView('mail.register_harian', ["surat" => $data_surat,'tanggal'=>$tanggal,'signer'=>$signer])->setPaper([0, 0, 595.276, 935.433], 'landscape');
   



        return $pdf->download('register-' . $tanggal . '.pdf');
    }

    public function terimaArsip(Request $request)
    {
        $id_surat = $request->input('id_surat');
        if (DB::table('mails')->where('id', $id_surat)->update(['arsip' => 'Y'])) {
            $request->session()->flash('success', 'Arsip berhasil diterima!');

            return response()->json(['success']);
        }
    }

    public function template_mail()
    {
        $data_template = DB::table('template_surat')->get();
        return view('mail.template_list', ['data' => $data_template]);
    }

    public function modal_template_surat(Request $request)
    {

        return response()->json(['modal' => view('mail.modal_template')->render()]);
    }

    public function tambah_template(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [

                'file_template' => 'required|mimes:docx,doc,rtf',
                'nama_template' => 'required',
                'keterangan' => 'required',

            ],

            [

                'file_template.required' => 'File template harus diupload',
                'file_template.mimes' => 'Jenis file salah',
                'nama_template.required' => 'Nama template harus diisi',
                'keterangan.required' => 'Keterangan harus diisi',
            ]
        );
        if ($validator->fails()) {
            return redirect('template_mail')
                ->withErrors($validator)
                ->withInput();
        }



        $validated = $validator->safe();



        $file = $validated['nama_template'] . '-' . time() . '.' . $validated['file_template']->getClientOriginalExtension();


        $validated['file_template']->move('file_template', $file);

        $input = array_merge(Arr::except($validated->toArray(), 'file_template'), ['file' => $file]);

        DB::table('template_surat')->insert($input);
        return redirect('template_mail')->with('success', 'File berhasil diupload');
    }

    public function modal_edit_template_surat(Request $request)
    {
        $id = $request->id;
        $data_template = DB::table('template_surat')->where('id', $id)->first();
        return response()->json(['modal' => view('mail.modal_edit_template', ['data' => $data_template])->render()]);
    }

    public function edit_template(Request $request)
    {

        if ($request->file_template) {

            $validator = Validator::make(
                $request->all(),
                [

                    'file_template' => 'mimes:docx,doc,rtf',
                    'nama_template' => 'required',
                    'keterangan' => 'required',

                ],

                [

                    'file_template.mimes' => 'Jenis file salah',
                    'nama_template.required' => 'Nama template harus diisi',
                    'keterangan.required' => 'Keterangan harus diisi',
                ]
            );
        }
        if (!$request->file_template) {
            $validator = Validator::make(
                $request->all(),
                [


                    'nama_template' => 'required',
                    'keterangan' => 'required',

                ],

                [

                    'nama_template.required' => 'Nama template harus diisi',
                    'keterangan.required' => 'Keterangan harus diisi',
                ]
            );
        }
        if ($validator->fails()) {
            return redirect('template_mail')
                ->withErrors($validator)
                ->withInput();
        }

        $validated = $validator->safe();
        // dd($validated);

        if (isset($validated['file_template'])) {

            $file = $validated['nama_template'] . '-' . time() . '.' . $validated['file_template']->getClientOriginalExtension();
            $validated['file_template']->move('file_template', $file);
            $input = array_merge(Arr::except($validated->toArray(), 'file_template'), ['file' => $file]);
        } else {
            $file = $request->file_lama;
            $input = array_merge($validated->toArray(), ['file' => $file]);
        }


        DB::table('template_surat')->where('id', $request->id)->update($input);
        return redirect('template_mail')->with('success', 'File berhasil diupdate');
    }

    public function modalCetakSurat(Request $request)
    {
        $id_surat = $request->id_surat;

        return response()->json(['modal' => view('mail.modal_cetak_surat', ['id_surat' => $id_surat])->render()]);
    }

    public function cetakSurat(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'nomor_perkara' => ['required'],
                'jenis_penahanan' => ['required_unless:jenis_surat,pengantar_hari_sidang'],
                'jenis_surat' => ['required'],
                'nomor_penahanan.*' => ['required_if:jenis_surat,pengantar_penahanan,perpanjangan_penahanan'],
                'nama_terdakwa.*' => ['required_if:jenis_surat,pengantar_penahanan,perpanjangan_penahanan'],
                'nama_terdakwa_petikan' => ['required_if:jenis_surat,petikan_putusan, salinan_putusan,pengantar_hari_sidang'],
                'jumlah_terdakwa' => ['required_if:jenis_surat,petikan_putusan, salinan_putusan,pengantar_hari_sidang'],
            ],
            [
                'nomor_perkara' => 'Nomor perkara harus diisi',
                'jenis_penahanan' => 'Jenis penahanan harus diisi',
                'jenis_surat' => 'Jenis surat harus diisi',
                'nomor_penahanan.*' => 'Nomor penahanan harus diisi',
                'nama_terdakwa.*' => 'Nama terdakwa harus diisi',
                'nama_terdakwa_petikan' => 'Nama terdakwa harus diisi',
                'jumlah_terdakwa' => 'Jumlah terdakwa harus diisi',
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $data_surat = DB::table('mails')->where('id', $request->id_surat)->first();
        $input = $validator->safe();
        if ($input['jenis_surat'] == 'pengantar_penahanan') {

            $redaksi_penahanan = '';


            for ($i = 0; $i < count($input['nomor_penahanan']); $i++) {
                if ($i + 1 == count($input['nomor_penahanan'])) {
                    $redaksi_penahanan .= "dan Nomor " . $input['nomor_penahanan'][$i] . "  An Terdakwa " . $input['nama_terdakwa'][$i] . ";";
                    break;
                }
                $redaksi_penahanan .= "Nomor " . $input['nomor_penahanan'][$i] . " An. Terdakwa " . $input['nama_terdakwa'][$i] . ", ";
            }

            $jenis_terdakwa = count($input['nama_terdakwa']) == 1 ? 'Terdakwa' : 'Para Terdakwa';
            $nama_terdakwa = count($input['nama_terdakwa']) == 1 ? $input['nama_terdakwa'][0] . ";" : $input['nama_terdakwa'][0] . ", dkk";


            $isi_surat = "Penahanan Hakim Pengadilan Negeri Negara tanggal " . Carbon::parse($data_surat->tanggal_surat)->isoFormat('D MMMM Y') . " " . $redaksi_penahanan;

            $templatePengantar = new TemplateProcessor(asset('template_pengantar/surat_pengantar_penahanan.docx'));


            $templatePengantar->setValue('tanggal_surat', Carbon::parse($data_surat->tanggal_surat)->isoFormat('D MMMM Y'));
            $templatePengantar->setValue('nomor_surat', $data_surat->nomor_surat);
            $templatePengantar->setValue('isi_surat', $isi_surat);
            $templatePengantar->setValue('tembusan_terdakwa', count($input['nama_terdakwa']) == 1 ? 'Terdakwa' : 'Para Terdakwa');
            if ($input['jenis_penahanan'] == 'Y') {
                $templatePengantar->setValue('tembusan_3', "Kepala Rumah Tahanan Negara");
                $templatePengantar->setValue('tembusan_4', "4. Arsip");
            } else {
                $templatePengantar->setValue('tembusan_3', "Arsip");
                $templatePengantar->setValue('tembusan_4', "");
            }
            header("Content-Disposition: attachment; filename=Surat-pengantar-" . time() . ".docx");

            // $this->response->setContentType('application/vnd.openxmlformats-officedocument.wordprocessingml.document');
            // $this->response->setHeader('Content-Disposition', 'attachment;filename="Register-Permohonan' . time() . '.docx"');
            $pathToSave = 'php://output';
            $templatePengantar->saveAs($pathToSave);
        } elseif ($input['jenis_surat'] == 'pengantar_hari_sidang') {

            $jenis_terdakwa = $input->jumlah_terdakwa == 1 ? 'Terdakwa' : 'Para Terdakwa';
            $nama_terdakwa = $input->jumlah_terdakwa == 1 ? $input['nama_terdakwa_petikan'] . ";" : $input['nama_terdakwa_petikan'] . ", dkk";
            $redaksi_hari_sidang = "Penetapan hari sidang tanggal " . Carbon::parse($data_surat->tanggal_surat)->isoFormat('D MMMM Y') . " perkara nomor " . $input['nomor_perkara'] . " An. " . $jenis_terdakwa . " : " . $nama_terdakwa;

            $templatePengantar = new TemplateProcessor(asset('template_pengantar/surat_pengantar_hari_sidang.docx'));


            $templatePengantar->setValue('tanggal_surat', Carbon::parse($data_surat->tanggal_surat)->isoFormat('D MMMM Y'));
            $templatePengantar->setValue('nomor_surat', $data_surat->nomor_surat);
            $templatePengantar->setValue('isi_surat_hari_sidang', $redaksi_hari_sidang);

            header("Content-Disposition: attachment; filename=Surat-pengantar-" . time() . ".docx");

            // $this->response->setContentType('application/vnd.openxmlformats-officedocument.wordprocessingml.document');
            // $this->response->setHeader('Content-Disposition', 'attachment;filename="Register-Permohonan' . time() . '.docx"');
            $pathToSave = 'php://output';
            $templatePengantar->saveAs($pathToSave);
        } elseif ($input['jenis_surat'] == 'perpanjangan_penahanan') {
            $redaksi_penahanan = '';


            for ($i = 0; $i < count($input['nomor_penahanan']); $i++) {
                if ($i + 1 == count($input['nomor_penahanan'])) {
                    $redaksi_penahanan .= "dan Nomor " . $input['nomor_penahanan'][$i] . "  An Terdakwa " . $input['nama_terdakwa'][$i] . ";";
                    break;
                }
                $redaksi_penahanan .= "Nomor " . $input['nomor_penahanan'][$i] . " An. Terdakwa " . $input['nama_terdakwa'][$i] . ", ";
            }

            $jenis_terdakwa = count($input['nama_terdakwa']) == 1 ? 'Terdakwa' : 'Para Terdakwa';
            $nama_terdakwa = count($input['nama_terdakwa']) == 1 ? $input['nama_terdakwa'][0] . ";" : $input['nama_terdakwa'][0] . ", dkk";


            $isi_surat = "Perpanjangan Penahanan Ketua Pengadilan Negeri Negara tanggal " . Carbon::parse($data_surat->tanggal_surat)->isoFormat('D MMMM Y') . " " . $redaksi_penahanan;

            $templatePengantar = new TemplateProcessor(asset('template_pengantar/surat_pengantar_perpanjangan_penahanan.docx'));


            $templatePengantar->setValue('tanggal_surat', Carbon::parse($data_surat->tanggal_surat)->isoFormat('D MMMM Y'));
            $templatePengantar->setValue('nomor_surat', $data_surat->nomor_surat);
            $templatePengantar->setValue('isi_surat', $isi_surat);
            $templatePengantar->setValue('tembusan_terdakwa', count($input['nama_terdakwa']) == 1 ? 'Terdakwa' : 'Para Terdakwa');
            if ($input['jenis_penahanan'] == 'Y') {
                $templatePengantar->setValue('tembusan_3', "Kepala Rumah Tahanan Negara");
                $templatePengantar->setValue('tembusan_4', "4. Arsip");
            } else {
                $templatePengantar->setValue('tembusan_3', "Arsip");
                $templatePengantar->setValue('tembusan_4', "");
            }
            header("Content-Disposition: attachment; filename=Surat-pengantar-" . time() . ".docx");

            // $this->response->setContentType('application/vnd.openxmlformats-officedocument.wordprocessingml.document');
            // $this->response->setHeader('Content-Disposition', 'attachment;filename="Register-Permohonan' . time() . '.docx"');
            $pathToSave = 'php://output';
            $templatePengantar->saveAs($pathToSave);
        } elseif ($input['jenis_surat'] == 'petikan_putusan') {


            $jenis_terdakwa = $input->jumlah_terdakwa == 1 ? 'Terdakwa' : 'Para Terdakwa';
            $nama_terdakwa = $input->jumlah_terdakwa == 1 ? $input['nama_terdakwa_petikan'] . ";" : $input['nama_terdakwa_petikan'] . ", dkk";
            $redaksi_petikan = "Petikan putusan  tanggal " . Carbon::parse($data_surat->tanggal_surat)->isoFormat('D MMMM Y') . " perkara nomor " . $input['nomor_perkara'] . " An. " . $jenis_terdakwa . " : " . $nama_terdakwa;


            $templatePengantar = new TemplateProcessor(asset('template_pengantar/surat_pengantar_petikan.docx'));


            $templatePengantar->setValue('tanggal_surat', Carbon::parse($data_surat->tanggal_surat)->isoFormat('D MMMM Y'));
            $templatePengantar->setValue('nomor_surat', $data_surat->nomor_surat);
            $templatePengantar->setValue('isi_surat_petikan', $redaksi_petikan);

            $templatePengantar->setValue('tembusan_terdakwa', $input->jumlah_terdakwa == 1  ? 'Terdakwa' : 'Para Terdakwa');
            if ($input['jenis_penahanan'] == 'Y') {
                $templatePengantar->setValue('tembusan_3', "Kepala Rumah Tahanan Negara");
                $templatePengantar->setValue('tembusan_4', "4. Arsip");
            } else {
                $templatePengantar->setValue('tembusan_3', "Arsip");
                $templatePengantar->setValue('tembusan_4', "");
            }
            header("Content-Disposition: attachment; filename=Surat-pengantar-" . time() . ".docx");

            // $this->response->setContentType('application/vnd.openxmlformats-officedocument.wordprocessingml.document');
            // $this->response->setHeader('Content-Disposition', 'attachment;filename="Register-Permohonan' . time() . '.docx"');
            $pathToSave = 'php://output';
            $templatePengantar->saveAs($pathToSave);
        } elseif ($input['jenis_surat'] == 'salinan_putusan') {


            $jenis_terdakwa = $input->jumlah_terdakwa == 1 ? 'Terdakwa' : 'Para Terdakwa';
            $nama_terdakwa = $input->jumlah_terdakwa == 1 ? $input['nama_terdakwa_petikan'] . ";" : $input['nama_terdakwa_petikan'] . ", dkk";

            $redaksi_salinan = "Salinan putusan  tanggal " . Carbon::parse($data_surat->tanggal_surat)->isoFormat('D MMMM Y') . " perkara nomor " . $input['nomor_perkara'] . " An. " . $jenis_terdakwa . " : " . $nama_terdakwa;

            $templatePengantar = new TemplateProcessor(asset('template_pengantar/surat_pengantar_salinan.docx'));


            $templatePengantar->setValue('tanggal_surat', Carbon::parse($data_surat->tanggal_surat)->isoFormat('D MMMM Y'));
            $templatePengantar->setValue('nomor_surat', $data_surat->nomor_surat);

            $templatePengantar->setValue('isi_surat_salinan', $redaksi_salinan);
            $templatePengantar->setValue('tembusan_terdakwa', $input->jumlah_terdakwa == 1  ? 'Terdakwa' : 'Para Terdakwa');
            if ($input['jenis_penahanan'] == 'Y') {
                $templatePengantar->setValue('tembusan_3', "Kepala Rumah Tahanan Negara");
                $templatePengantar->setValue('tembusan_4', "4. Arsip");
            } else {
                $templatePengantar->setValue('tembusan_3', "Arsip");
                $templatePengantar->setValue('tembusan_4', "");
            }
            header("Content-Disposition: attachment; filename=Surat-pengantar-" . time() . ".docx");

            // $this->response->setContentType('application/vnd.openxmlformats-officedocument.wordprocessingml.document');
            // $this->response->setHeader('Content-Disposition', 'attachment;filename="Register-Permohonan' . time() . '.docx"');
            $pathToSave = 'php://output';
            $templatePengantar->saveAs($pathToSave);
        }
    }
}
