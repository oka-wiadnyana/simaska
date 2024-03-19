<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Good;
use Carbon\Carbon;

use Illuminate\Support\Facades\DB;
use DataTables;
use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use PDF;
use Livewire;


class RefController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request, $id = null)
    {
        return view('goods.good_list');

        //
    }

    public function getGoodsData(Request $request)
    {
        if ($request->ajax()) {
            $data = Good::orderBy('kode')->orderBy('urutan')->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('kode_barang', function ($row) {
                    $kode_barang = $row->kode && $row->urutan ? $row->kode . "-" . $row->urutan : "";
                    return $kode_barang;
                })

                ->addColumn('action', function ($row) {



                    // $actionBtn = '<a href="" class="edit-btn btn-success btn-sm" data-id="' . $row->id . '">Edit</a> <a href="" class="delete-btn btn-danger btn-sm"data-id="' .  $row->id . '">Delete</a>';
                    return Livewire::mount('editbutton', ['goods_id' => $row->id])->html() . " <a href='' class='btn-sm btn-danger delete-btn' data-id='" . $row->id . "'>Delete</a>";
                })
                ->rawColumns(['action', 'kode_barang'])
                ->make(true);
        }
    }

    public function html()
    {
        return $this->builder()
            // ->setTableId('data-table')
            // ->columns($this->getColumns())
            ->drawCallbackWithLivewire();
        // ->addAction(['width' => '80px'])
        // ->orderBy(1);
    }

    public function deleteBarang(Request $request)
    {
        $id = $request->id;
        Good::destroy($id);
        session()->flash('success', 'Data berhasil dihapus');
        return response()->json(['msg' => 'success']);
    }

    public function insertRefBarang(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kode.*' => 'required',
            'nama_barang.*' => 'required',
            'satuan.*' => 'required',
        ], [
            'kode.*.required' => ':attribute harus diiisi',
            'nama_barang.*.required' => ':attribute harus diiisi',
            'satuan.*.required' => ':attribute harus diiisi'
        ]);

        if ($validator->fails()) {
            return redirect('goods')
                ->withErrors($validator)
                ->withInput();
        }

        $validated = $validator->validated();
        // dd($validated);

        for ($i = 0; $i < count($validated['nama_barang']); $i++) {

            $max_urutan = Good::where('kode', $validated['kode'][$i])->max('urutan');

            if ($max_urutan) {
                $urutan_baru = $max_urutan + 1;
            } else {
                $urutan_baru = 1;
            }
            Good::create([
                'nama_barang' => $validated['nama_barang'][$i],
                'satuan' => $validated['satuan'][$i],
                'kode' => $validated['kode'][$i],
                'urutan' => $urutan_baru,

            ]);
        }

        return redirect('/goods')->with('success', count($validated['nama_barang']) . " data berhasil diinput");
    }

    public function editRefBarang(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'nama_barang' => ['required'],
            'satuan' => ['required']
        ]);

        if ($validator->fails()) {
            return redirect('goods')
                ->withErrors($validator)
                ->withInput();
        }

        Good::where('id', $request->id)->update($validator->safe()->toArray());
        return redirect('/goods')->with('success', "Data berhasil diubah");
    }

    public function refJenisBarang()
    {
        return view('goods.ref_jenis_barang');
    }

    public function getRefBarang(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('ref_jenis_barang')->get();
            return Datatables::of($data)
                ->addIndexColumn()

                ->addColumn('action', function ($row) {
                    $btn = "<a href='' class='btn btn-primary edit-btn' data-id='" . $row->id . "'>Edit</a> <a href='' class='btn btn-danger delete-btn' data-id='" . $row->id . "'>Delete</a>";

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function modalTambahJenis(Request $request)
    {

        return response()->json(['modal' => view('goods.modal_tambah_barang')->render()]);
    }

    public function insertJenisBarang(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'kode' => 'required',
                'uraian' => 'required'
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        DB::table('ref_jenis_barang')->insert(['kode' => $validator->safe()['kode'], 'uraian' => $validator->safe()['uraian']]);

        return redirect()->back()->with('success', 'Data berhasil diinput');
    }

    public function modalEditJenis(Request $request)
    {
        $id = $request->id;
        $data = DB::table('ref_jenis_barang')->find($id);

        return response()->json(['modal' => view('goods.modal_edit_barang', ['data' => $data])->render()]);
    }

    public function editJenisBarang(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'kode' => 'required',
                'uraian' => 'required'
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        DB::table('ref_jenis_barang')->where('id', $request->id)->update(['kode' => $validator->safe()['kode'], 'uraian' => $validator->safe()['uraian']]);

        return redirect()->back()->with('success', 'Data berhasil diupdate');
    }

    public function deleteJenisBarang(Request $request)
    {
        DB::table('ref_jenis_barang')->where('id', $request->id)->delete();

        session()->flash('success', 'Data berhasil dihapus');
        return response()->json(['msg' => 'success']);
    }
    public function importBarang(Request $request)
    {

        return response()->json(['modal' => view('goods.modal_import')->render()]);
    }

    public function importExcel(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'file' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $file = $request->file('file');
        $file_name = time() . '.' . $file->getClientOriginalExtension();
        $file->storeAs('file_ref_barang', $file_name);

        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        // Tell the reader to only read the data. Ignore formatting etc.
        $reader->setReadDataOnly(true);

        // Read the spreadsheet file.
        // $spreadsheet = $reader->load(base_url('raw_file/ceklist.xlsx'));
        $spreadsheet = $reader->load(new \Illuminate\Http\File(base_path('storage/app/file_ref_barang/' . $file_name)));

        $sheet = $spreadsheet->getSheet($spreadsheet->getFirstSheetIndex());
        $data = $sheet->toArray();


        $affected = 0;
        foreach ($data as $key => $value) {
            if ($key == 0) {
                continue;
            }

            $data_insert = [
                'nama_barang' => $value[1],
                'satuan' => $value[2],
                'kode' => $value[3],
                'urutan' => $value[4],


            ];

            // dd($data_insert);
            DB::table('goods')->insert($data_insert);

            $affected++;
        }



        return redirect()->back()->with('success', $affected . ' data berhasil diinput');
    }

    public function hapusAll()
    {
        DB::table('goods')->truncate();
        session()->flash('success', 'Semua data berhasil dihapus');
        return response()->json(['msg' => 'success']);
    }
}
