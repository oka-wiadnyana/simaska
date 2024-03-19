<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\PpnpnAssessment;
use Illuminate\Http\Request;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpWord\TemplateProcessor;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;

class PpnpnAssessmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function ppnpn(Request $request, $id = null)
    {
        return view('review.ppnpn_assessment_list');

        //
    }

    public function getResultPpnpnAssessment(Request $request)
    {
   
        if ($request->ajax()) {
            $data = session('kepegawaian')==true?PpnpnAssessment::latest()->get():PpnpnAssessment::where('penilai_id',session('employee_id'))->get();
            
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $actionBtn = '<a href="" class="edit btn btn-success btn-sm" onclick="showModalEdit(\'show-modal-edit-officer\','.$row->id.'); return false">Edit</a> <a href=""  onclick="deleteData();return false" class="delete btn btn-danger btn-sm">Delete</a> ';
                    return $actionBtn;
                })
                ->addColumn('ppnpn_name', function($row){
                    
                    return $row->dataPpnpn->nama;
                })
                ->addColumn('bulan', function($row){
                    
                    return Carbon::create($row->bulan)->startOfMonth()->isoFormat('MMMM');
                })
               
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function modalTambahPenilaian(Request $request)
    {
        $ppnpn = Employee::whereHas('position',function($q){
            $q->where('is_ppnpn','Y');
        })->get();
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

        return response()->json(['modal' => view('review.modal_tambah_penilaian_ppnpn', ['ppnpns' => $ppnpn, 'bulans' => $bulan, 'tahuns' => $tahun_array])->render()]);
    }

    public function insertPenilaian(Request $request){
        $validate=Validator::make(
            $request->all(),
            [
                'bulan'=>'required',
                'tahun'=>'required',
                'ppnpn_id'=>'required',
                'integritas'=>'required',
                'kedisiplinan'=>'required',
                'kerjasama'=>'required',
                'komunikasi'=>'required',
                'pelayanan'=>'required',
               
            ]
            );

            if($validate->fails()){
                return back()->withErrors($validate);
            }

            if($request->is_admin &&$request->is_admin=='true'){
                $hariIsExist=DB::table('table_ppnpn_assessment')->where('bulan',$request->bulan)->where('tahun',$request->tahun)->where('ppnpn_id',$request->ppnpn_id)->first();

                if($hariIsExist){
                    if($request->jumlah_kehadiran || $request->jumlah_hari_kerja){
                        return back()->with('fail','Data hari kerja atau kehadiran sudah diisi admin lain');
                    }
                }else {
                    return back()->with('fail','Isikan jumlah kehadiran dan jumlah hari kerja');
                }
                
            }

            $dataInsert=[
                    'bulan'=>$request->bulan,
                    'tahun'=>$request->tahun,
                    'ppnpn_id'=>$request->ppnpn_id,
                    'integritas'=>$request->integritas,
                    'kedisiplinan'=>$request->kedisiplinan,
                    'kerjasama'=>$request->kerjasama,
                    'komunikasi'=>$request->komunikasi,
                    'pelayanan'=>$request->pelayanan,
                    'evaluasi'=>$request->evaluasi,
                    'penilai_id'=>session('employee_id'),
                    
            ];

            if($request->is_admin &&$request->is_admin=='true'){
                $dataInsert=array_merge($dataInsert,[
                    'jumlah_kehadiran'=>$request->jumlah_kehadiran,
                    'jumlah_hari_kerja'=>$request->jumlah_hari_kerja,
                ]);
            }
            

            try{
                PpnpnAssessment::updateOrCreate(
                    [
                        'id'=>$request->id
                    ],
                   $dataInsert
                );
                return back()->with('success','Data berhasil diinsert');

            }catch(\Exception $e){
                return back()->with('fail',$e->getMessage());
            }
            


    }

    public function modalCetakReviewBulanan(Request $request)
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
        $ppnpn = Employee::whereHas('position',function($q){
            $q->where('is_ppnpn','Y');
        })->get();

        return response()->json(['modal' => view('review.modal_cetak_penilaian_ppnpn',['bulans'=>$bulan,'tahuns'=>$tahun_array,'ppnpns'=>$ppnpn])->render()]);
    }
    public function printReportBulanan(Request $request){

        $validate=Validator::make(
            $request->all(),
            [
                'ppnpn_id'=>['required'],
                'bulan'=>['required'],
                'tahun'=>['required'],
                // 'date'=>['required'],
                // 'pic_id'=>['required'],
                // 'higher_id'=>['required'],
            ]
        );

        if($validate->fails()){
          
            return back()->withErrors($validate);
        }

        // $result=PpnpnAssessment::where('ppnpn_id',$request->ppnpn_id)->select('ppnpn_id',DB::raw('sum(integritas) as sum_integritas'),DB::raw('sum(kedisiplinan) as sum_kedisiplinan'),DB::raw('count(result) as count_res'),DB::raw('((sum(result)/count(result))*100)/5 as avg'))->whereMonth('assessment_date',$request->month)->whereYear('assessment_date',$request->year)->get();
        $result=PpnpnAssessment::where('ppnpn_id',$request->ppnpn_id)->where('bulan',$request->bulan)->where('tahun',$request->tahun)->get();
        $hariAbsen=$result->first(function ($value,$key){
            return $value->jumlah_kehadiran!=null;
        });
        if(!$hariAbsen){
            return back()->with('fail','Belum ada hari kehadiran dan hari kerja untuk pegawai ini');
        }
        
        $jumlahPenilaian=$result->count();
        $integritas=round($result->sum('integritas')/$jumlahPenilaian);
        $kedisiplinan=round($result->sum('kedisiplinan')/$jumlahPenilaian);
        $kerjasama=round($result->sum('kerjasama')/$jumlahPenilaian);
        $komunikasi=round($result->sum('komunikasi')/$jumlahPenilaian);
        $pelayanan=round($result->sum('pelayanan')/$jumlahPenilaian);
        $nilaiPerilakuKerja=($integritas+$kedisiplinan+$kerjasama+$komunikasi+$pelayanan)/5;
        $nilaiKehadiran=($hariAbsen->jumlah_kehadiran/$hariAbsen->jumlah_hari_kerja)*100;
        $penilaianKinerja=($nilaiPerilakuKerja*50/100)+($nilaiKehadiran*50/100);
        // dd($jumlahPenilaian,$integritas,$kedisiplinan,$kerjasama,$komunikasi,$pelayanan,$nilaiKehadiran,$nilaiPerilakuKerja,$penilaianKinerja);
        // $dataPrint=[];
        

        $template = new TemplateProcessor(public_path('/ppnpn/template_penilaian.docx'));
       
        $bulanRead=Carbon::create()->startOfMonth()->month($request->bulan)->isoFormat('MMMM');

        $template->setValue('bulan', Str::camel($bulanRead));
        $template->setValue('tahun', $request->tahun);
        $template->setValue('nama', $result[0]->dataPpnpn->nama);
        $template->setValue('jabatan',$result[0]->positionPpnpn->nama_jabatan);
        $template->setValue('unit_kerja', $result[0]->unitPpnpn->nama_unit);
        $template->setValue('integritas', $integritas);
        $template->setValue('kedisiplinan', $kedisiplinan);
        $template->setValue('kerjasama', $kerjasama);
        $template->setValue('komunikasi', $komunikasi);
        $template->setValue('pelayanan', $pelayanan);
        $template->setValue('jumlah_kehadiran', $hariAbsen->jumlah_kehadiran);
        $template->setValue('jumlah_hari_kerja', $hariAbsen->jumlah_hari_kerja);
        
        
        $template->setValue('nilai_perilaku_kerja', $nilaiPerilakuKerja);
        $template->setValue('nilai_kehadiran', $nilaiKehadiran);
        $template->setValue('penilaian_kinerja', $penilaianKinerja);
        


        header("Content-Disposition: attachment; filename=Form-Penilaian-".$request->month."-".$request->year."-" . time() . ".docx");
        $pathToSave = 'php://output';
        $template->saveAs($pathToSave);
        return;
    }

}
