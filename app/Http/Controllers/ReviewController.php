<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\PetugasPtsp;
use App\Models\PetugasSatpam;
use App\Models\ResultReviewPtsp;
use App\Models\ResultReviewSatpam;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpWord\TemplateProcessor;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;

class ReviewController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function ptsp(Request $request, $id = null)
    {
        return view('review.result_list');

        //
    }

    public function getResultPtsp(Request $request)
    {
   
        if ($request->ajax()) {
            $data = ResultReviewPtsp::latest()->get();
            
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $actionBtn = '<a href="" class="edit btn btn-success btn-sm" onclick="showModalEdit(\'show-modal-edit-officer\','.$row->id.'); return false">Edit</a> <a href=""  onclick="deleteData();return false" class="delete btn btn-danger btn-sm">Delete</a> ';
                    return $actionBtn;
                })
                ->addColumn('unit_name', function($row){
                    
                    return $row->unitName->unit_name;
                })
                ->addColumn('officer_name', function($row){
                    
                    return $row->officerName->name;
                })
                ->addColumn('officer_nip', function($row){
                    
                    return $row->officerName->nip;
                })
                ->addColumn('officer_department', function($row){
                    
                    return $row->officerName->department;
                })
               
                ->rawColumns(['action'])
                ->make(true);
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


        return response()->json(['modal' => view('review.modal_cetak_bulanan',['bulan'=>$bulan,'tahun'=>$tahun_array,'pegawai'=>Employee::all()])->render()]);
    }
    public function printReportBulanan(Request $request){

        $validate=Validator::make(
            $request->all(),
            [
                'month'=>['required'],
                'year'=>['required'],
                'date'=>['required'],
                'pic_id'=>['required'],
                'higher_id'=>['required'],
            ]
        );

        if($validate->fails()){
          
            return back()->withErrors($validate);
        }

        $result=ResultReviewPtsp::groupBy('officer_id')->select('officer_id',DB::raw('sum(result) as sum_res'),DB::raw('count(result) as count_res'),DB::raw('((sum(result)/count(result))*100)/5 as avg'),)->whereMonth('assessment_date',$request->month)->whereYear('assessment_date',$request->year)->get();
        $dataPrint=[];
        if(!$result->isEmpty()){

            $result=$result->sortByDesc('avg');
            
            $no=1;

            foreach($result as $res){
                $dataPrint[]=[
                    'nomor'=>$no++,
                    'nama'=>$res->officerName->name,
                    'unit'=>$res->unitName->unit_name,
                    'total'=>$res->sum_res,
                    'jumlah'=>$res->count_res,
                    'avg'=>number_format($res->avg,'2',',','.'),
                ];
            }
        }else {
            $dataPrint[]=[
                'nomor'=>'-',
                'nama'=>'-',
                'unit'=>'-',
                'total'=>'-',
                'jumlah'=>'-',
                'avg'=>'-',
            ];
        }

        $pic=Employee::where('id',$request->pic_id)->first();
        // dd($pic->position);
        $mengetahui=Employee::where('id',$request->higher_id)->first();

        

        // dd($dataPrint);


        

        $template = new TemplateProcessor(public_path('/review/template_laporan.docx'));
        $tanggalRead = Carbon::parse($request->date)->isoFormat('DD MMMM YYYY');
        $bulanRead=Carbon::create()->startOfMonth()->month($request->month)->isoFormat('MMMM');

        $template->setValue('bulan', Str::upper($bulanRead));
        $template->setValue('tahun', $request->year);
        $template->setValue('tanggal', $tanggalRead);
        $template->setValue('jabatan_mengetahui', $mengetahui->position->nama_jabatan);
        $template->setValue('nama_mengetahui', $mengetahui->nama);
        $template->setValue('nip_mengetahui', $mengetahui->nip);
        
        $template->setValue('jabatan_pic', $pic->position->nama_jabatan);
        $template->setValue('nama_pic', $pic->nama);
        $template->setValue('nip_pic', $pic->nip);
        

        $template->cloneRowAndSetValues('nomor', $dataPrint);



        header("Content-Disposition: attachment; filename=Form-Result-".$request->month."-".$request->year."-" . time() . ".docx");
        $pathToSave = 'php://output';
        $template->saveAs($pathToSave);
        return;
    }
    public function modalCetakReviewPtspHarian(Request $request)
    {
       
        return response()->json(['modal' => view('review.modal_cetak_harian_ptsp',['pegawai'=>Employee::all()])->render()]);
    }

    public function printReportHarianPtsp(Request $request){

        $validate=Validator::make(
            $request->all(),
            [
                'review_date'=>['required'],
               
                'date'=>['required'],
                'pic_id'=>['required'],
                'higher_id'=>['required'],
            ]
        );

        if($validate->fails()){
          
            return back()->withErrors($validate);
        }

        $result=ResultReviewPtsp::where('assessment_date',$request->review_date)->get();
        $dataPrint=[];
        if(!$result->isEmpty()){

                      
            $no=1;

            foreach($result as $res){
                $dataPrint[]=[
                    'nomor'=>$no++,
                    'nama'=>$res->officerName->name,
                    'nip'=>$res->officerName->nip,
                    'unit'=>$res->unitName->unit_name,
                    'jabatan'=>$res->officerName->department,
                   
                    'nilai'=>$res->result,
                    'evaluasi'=>$res->evaluation,
                ];
            }
        }else {
            $dataPrint[]=[
                'nomor'=>'-',
                'nama'=>'-',
                'nip'=>'-',
                'unit'=>'-',
                'jabatan'=>'-',
                'nilai'=>'-',
                'evaluasi'=>'-',
               
            ];
        }

        $pic=Employee::where('id',$request->pic_id)->first();
        // dd($pic->position);
        $mengetahui=Employee::where('id',$request->higher_id)->first();

        

        // dd($dataPrint);


        

        $template = new TemplateProcessor(public_path('/review/template_laporan_ptsp_harian.docx'));
        $tanggalRead = Carbon::parse($request->date)->isoFormat('DD MMMM YYYY');
      
        $template->setValue('tanggal_review', Carbon::parse($request->review_date)->isoFormat('DD MMMM YYYY'));
       
        $template->setValue('tanggal', $tanggalRead);
        $template->setValue('jabatan_mengetahui', $mengetahui->position->nama_jabatan);
        $template->setValue('nama_mengetahui', $mengetahui->nama);
        $template->setValue('nip_mengetahui', $mengetahui->nip);
        
        $template->setValue('jabatan_pic', $pic->position->nama_jabatan);
        $template->setValue('nama_pic', $pic->nama);
        $template->setValue('nip_pic', $pic->nip);
        

        $template->cloneRowAndSetValues('nomor', $dataPrint);



        header("Content-Disposition: attachment; filename=Form-Result-Harian-".$request->month."-".$request->year."-" . time() . ".docx");
        $pathToSave = 'php://output';
        $template->saveAs($pathToSave);
        return;
    }

    public function petugasPtsp(Request $request, $id = null)
    {
        return view('review.petugas_ptsp_list');

        //
    }

    public function getListPetugasPtsp(Request $request)
    {
   
        if ($request->ajax()) {
            $data = PetugasPtsp::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $actionBtn = '<a href="" class="edit btn btn-success btn-sm update-btn" data-id="'.$row->id.'">Edit</a> <a href=""  onclick="deleteData(\''.route('review.destroy_officer').'\','.$row->id.',\'Ubah Aktivasi?\');return false" class="delete btn btn-danger btn-sm">Ubah Aktivasi</a> ';
                    return $actionBtn;
                })
                ->addColumn('unit_name', function($row){
                    
                    return $row->unitName->unit_name;
                })
                ->addColumn('active', function($row){
                    
                    return $row->active=='true'?'Aktif':'Tidak Aktif';
                })
               
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function activateOfficer(Request $request){

        $officer=PetugasPtsp::find($request->id);
        $isActive=$officer->active=='true'?'false':'true';
        PetugasPtsp::where('id',$request->id)->update(['active'=>$isActive]);

        session()->flash('success', 'Petugas berhasil diribah');
        return response()->json(['success']);

    }

    public function addPtspOfficer(Request $request)
    {
       
        $unit=DB::connection('review')->table('unit')->get();
        

        return response()->json(['modal' => view('review.modal_tambah_petugas_ptsp',[
            'unit'=>$unit
        ])->render()]);
    }

    public function editPtspOfficer(Request $request)
    {
        $unit=DB::connection('review')->table('unit')->get();
        $id=$request->id_pegawai;
        $data=PetugasPtsp::find($id);
     
        return response()->json(['modal' => view('review.modal_edit_petugas_ptsp',compact('data','unit'))->render()]);
    }

    public function insertPtspOfficer(Request $request){
        $validate=Validator::make(
            $request->all(),
            [
                'name'=>['required'],
                'nick_name'=>['required'],
                'nip'=>['required'],
                'department'=>['required'],
                'unit_id'=>['required'],
              
                'foto'=>['required_without:foto_lama','mimes:jpeg,jpg,bmp,png']
            ]
        );

        if($validate->fails()){
            // dd($validate->errors()->all());
          
            return back()->withErrors($validate);
        }
        
        
        
        $validated=$validate->safe()->all();
     $msg="";
        if($request->hasFile('foto') && $request->foto->isValid()){
            $fileFoto=$request->foto;
            $foto=$validated['nip'].'-'.time().'.'.$fileFoto->getClientOriginalExtension();
          
            
            $photo = file_get_contents($fileFoto->getPathName());
         

            $response = Http::attach(
                'foto', $photo, $foto
            )->post('https://review.pt-denpasar.info/api/upload_foto');

            $msg=json_decode($response->body(),true)['message'];
         
        }else {
            $foto=$request->foto_lama;
            $msg="Data menggunakan foto lama";
        }

        PetugasPtsp::updateOrCreate(
            ['id'=>$request->id],
            [
                'name'=>$request->name,
                'nick_name'=>$request->nick_name,
                'nip'=>$request->nip,
                'department'=>$request->department,
                'unit_id'=>$request->unit_id,
                'foto'=>$foto
            ]
        );

        
        return back()->with('success',$msg);
    }

    public function petugasSatpam(Request $request, $id = null)
    {
        return view('review.petugas_satpam_list');

        //
    }

    public function getListPetugasSatpam(Request $request)
    {
   
        if ($request->ajax()) {
            $data = PetugasSatpam::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $actionBtn = '<a href="" class="edit btn btn-success btn-sm update-btn" data-id="'.$row->id.'">Edit</a> <a href=""  onclick="deleteData(\''.route('review.destroy_officer_satpam').'\','.$row->id.',\'Ubah Aktivasi?\');return false" class="delete btn btn-danger btn-sm">Ubah Aktivasi</a> ';
                    return $actionBtn;
                })
               
                ->addColumn('active', function($row){
                    
                    return $row->active=='true'?'Aktif':'Tidak Aktif';
                })
               
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function addSatpamOfficer(Request $request)
    {
       
     
        return response()->json(['modal' => view('review.modal_tambah_petugas_satpam')->render()]);
    }
    

    public function insertSatpamOfficer(Request $request){
        $validate=Validator::make(
            $request->all(),
            [
                'name'=>['required'],
                'nick_name'=>['required'],
                'nip'=>['required'],
               
                'foto'=>['required_without:foto_lama','mimes:jpeg,jpg,bmp,png']
            ]
        );

        if($validate->fails()){
            // dd($validate->errors()->all());
          
            return back()->withErrors($validate);
        }
        
        
        
        $validated=$validate->safe()->all();
     $msg="";
        if($request->hasFile('foto') && $request->foto->isValid()){
            $fileFoto=$request->foto;
            $foto=$validated['nip'].'-'.time().'.'.$fileFoto->getClientOriginalExtension();
          
            
            $photo = file_get_contents($fileFoto->getPathName());
         

            $response = Http::attach(
                'foto', $photo, $foto
            )->post('https://review.pt-denpasar.info/api/upload_foto_satpam');

            $msg=json_decode($response->body(),true)['message'];
         
        }else {
            $foto=$request->foto_lama;
            $msg="Data menggunakan foto lama";
        }

        PetugasSatpam::updateOrCreate(
            ['id'=>$request->id],
            [
                'name'=>$request->name,
                'nick_name'=>$request->nick_name,
                'nip'=>$request->nip,
               
                'foto'=>$foto
            ]
        );

        
        return back()->with('success',$msg);
    }

    public function activateOfficerSatpam(Request $request){

        $officer=PetugasSatpam::find($request->id);
        $isActive=$officer->active=='true'?'false':'true';
        PetugasSatpam::where('id',$request->id)->update(['active'=>$isActive]);

        session()->flash('success', 'Petugas berhasil diribah');
        return response()->json(['success']);

    }

    public function editSatpamOfficer(Request $request)
    {
       
        $id=$request->id_pegawai;
        $data=PetugasSatpam::find($id);
     
        return response()->json(['modal' => view('review.modal_edit_petugas_satpam',compact('data'))->render()]);
    }

    public function satpam(Request $request, $id = null)
    {
        return view('review.satpam_result_list');

        //
    }

    public function getResultSatpam(Request $request)
    {
   
        if ($request->ajax()) {
            $data = ResultReviewSatpam::latest()->get();
            
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $actionBtn = '<a href="" class="edit btn btn-success btn-sm" onclick="showModalEdit(\'show-modal-edit-officer\','.$row->id.'); return false">Edit</a> <a href=""  onclick="deleteData();return false" class="delete btn btn-danger btn-sm">Delete</a> ';
                    return $actionBtn;
                })
              
                ->addColumn('name', function($row){
                    
                    return $row->officerName->name;
                })
                ->addColumn('nip', function($row){
                    
                    return $row->officerName->nip;
                })
              
               
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function modalCetakReviewSatpamBulanan(Request $request)
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


        return response()->json(['modal' => view('review.modal_cetak_bulanan_satpam',['bulan'=>$bulan,'tahun'=>$tahun_array,'pegawai'=>Employee::all()])->render()]);
    }
    public function printReportBulananSatpam(Request $request){

        $validate=Validator::make(
            $request->all(),
            [
                'month'=>['required'],
                'year'=>['required'],
                'date'=>['required'],
                'pic_id'=>['required'],
                'higher_id'=>['required'],
            ]
        );

        if($validate->fails()){
          
            return back()->withErrors($validate);
        }

        $result=ResultReviewSatpam::groupBy('officer_id')->select('officer_id',DB::raw('sum(result) as sum_res'),DB::raw('count(result) as count_res'),DB::raw('((sum(result)/count(result))*100)/5 as avg'),)->whereMonth('assessment_date',$request->month)->whereYear('assessment_date',$request->year)->get();
        $dataPrint=[];
        if(!$result->isEmpty()){

            $result=$result->sortByDesc('avg');
            
            $no=1;

            foreach($result as $res){
                $dataPrint[]=[
                    'nomor'=>$no++,
                    'nama'=>$res->officerName->name,
                    // 'unit'=>$res->unitName->unit_name,
                    'total'=>$res->sum_res,
                    'jumlah'=>$res->count_res,
                    'avg'=>number_format($res->avg,'2',',','.'),
                ];
            }
        }else {
            $dataPrint[]=[
                'nomor'=>'-',
                'nama'=>'-',
                // 'unit'=>'-',
                'total'=>'-',
                'jumlah'=>'-',
                'avg'=>'-',
            ];
        }

        $pic=Employee::where('id',$request->pic_id)->first();
        // dd($pic->position);
        $mengetahui=Employee::where('id',$request->higher_id)->first();

        

        // dd($dataPrint);


        

        $template = new TemplateProcessor(public_path('/review/template_laporan_satpam.docx'));
        $tanggalRead = Carbon::parse($request->date)->isoFormat('DD MMMM YYYY');
        $bulanRead=Carbon::create()->startOfMonth()->month($request->month)->isoFormat('MMMM');

        $template->setValue('bulan', Str::upper($bulanRead));
        $template->setValue('tahun', $request->year);
        $template->setValue('tanggal', $tanggalRead);
        $template->setValue('jabatan_mengetahui', $mengetahui->position->nama_jabatan);
        $template->setValue('nama_mengetahui', $mengetahui->nama);
        $template->setValue('nip_mengetahui', $mengetahui->nip);
        
        $template->setValue('jabatan_pic', $pic->position->nama_jabatan);
        $template->setValue('nama_pic', $pic->nama);
        $template->setValue('nip_pic', $pic->nip);
        

        $template->cloneRowAndSetValues('nomor', $dataPrint);



        header("Content-Disposition: attachment; filename=Form-Result-".$request->month."-".$request->year."-" . time() . ".docx");
        $pathToSave = 'php://output';
        $template->saveAs($pathToSave);
        return;
    }

    public function modalCetakReviewSatpamHarian(Request $request)
    {
       
        return response()->json(['modal' => view('review.modal_cetak_harian_satpam',['pegawai'=>Employee::all()])->render()]);
    }

    public function printReportHarianSatpam(Request $request){

        $validate=Validator::make(
            $request->all(),
            [
                'review_date'=>['required'],
               
                'date'=>['required'],
                'pic_id'=>['required'],
                'higher_id'=>['required'],
            ]
        );

        if($validate->fails()){
          
            return back()->withErrors($validate);
        }

        $result=ResultReviewSatpam::where('assessment_date',$request->review_date)->get();
        $dataPrint=[];
        if(!$result->isEmpty()){

                      
            $no=1;

            foreach($result as $res){
                $dataPrint[]=[
                    'nomor'=>$no++,
                    'nama'=>$res->officerName->name,
                    'nip'=>$res->officerName->nip,
                    // 'unit'=>$res->unitName->unit_name,
                    // 'tanggal'=>$res->sum_res,
                    'nilai'=>$res->result,
                    'evaluasi'=>$res->evaluation,
                ];
            }
        }else {
            $dataPrint[]=[
                'nomor'=>'-',
                'nama'=>'-',
                'nip'=>'-',
                'nilai'=>'-',
                'evaluasi'=>'-',
               
            ];
        }

        $pic=Employee::where('id',$request->pic_id)->first();
        // dd($pic->position);
        $mengetahui=Employee::where('id',$request->higher_id)->first();

        

        // dd($dataPrint);


        

        $template = new TemplateProcessor(public_path('/review/template_laporan_satpam_harian.docx'));
        $tanggalRead = Carbon::parse($request->date)->isoFormat('DD MMMM YYYY');
      
        $template->setValue('tanggal_review', Carbon::parse($request->review_date)->isoFormat('DD MMMM YYYY'));
       
        $template->setValue('tanggal', $tanggalRead);
        $template->setValue('jabatan_mengetahui', $mengetahui->position->nama_jabatan);
        $template->setValue('nama_mengetahui', $mengetahui->nama);
        $template->setValue('nip_mengetahui', $mengetahui->nip);
        
        $template->setValue('jabatan_pic', $pic->position->nama_jabatan);
        $template->setValue('nama_pic', $pic->nama);
        $template->setValue('nip_pic', $pic->nip);
        

        $template->cloneRowAndSetValues('nomor', $dataPrint);



        header("Content-Disposition: attachment; filename=Form-Result-Harian-".$request->month."-".$request->year."-" . time() . ".docx");
        $pathToSave = 'php://output';
        $template->saveAs($pathToSave);
        return;
    }

}
