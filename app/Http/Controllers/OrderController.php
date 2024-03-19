<?php

namespace App\Http\Controllers;

use App\Models\Fullfill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use DataTables;
use PDF;
use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Facades\Validator;
use App\Models\Order;
use App\Models\Orderdetail;
use App\Models\Orderfullfill;
use GuzzleHttp\Psr7\Request as Psr7Request;
use \Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;
use App\Models\Good;
use Illuminate\Support\Arr;
//load phpspreadsheet class using namespaces
use PhpOffice\PhpSpreadsheet\Spreadsheet;
//call iofactory instead of xlsx writer
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use App\Rules\ValidateArrayElement;


class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
        return view('order.order_list');
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
        $spreadsheet = $reader->load(public_path('klasifikasi_surat/KLASIFIKASI_IMPORT.xlsx'));

        $sheet = $spreadsheet->getSheet($spreadsheet->getFirstSheetIndex());
        $data = $sheet->toArray();

        DB::table('klasifikasi_kka')->truncate();
        // dd($data);
        $affected = 0;
        foreach ($data as $key => $value) {
            // if ($key == 0) {
            //     continue;
            // }

            $data_insert = [
                'kode' => $value[0],
                'keterangan' => $value[1],

            ];

            DB::table('klasifikasi_kka')->insert($data_insert);
            $affected++;
        }


        echo "data berhasi diupdate";
    }

    public function getOrdersData(Request $request, string $jenis = null)
    {
        if ($request->ajax()) {
            // $jenis = $request->segment(2);


            if (session('tu_rt') == true || session('keuangan') == true  ) {
                $data = [];
                if ($jenis == "terpenuhi") {

                    $data = DB::table('orders as a')->select(
                        'a.*',
                        'c.*',
                        'd.*',
                        'a.id as order_id',
                        DB::raw("(SELECT count(id) FROM orderdetails b WHERE b.order_id=a.id) as total_count"),
                        DB::raw("(SELECT count(id) FROM orderdetails b WHERE b.order_id=a.id AND complete IS NOT NULL AND complete!='') as complete_count")
                    )->leftJoin('units as c', 'a.unit_id', '=', 'c.id')->leftJoin('employees as d', 'a.employee_id', '=', 'd.id')->havingRaw('total_count=complete_count')->get();
                } elseif ($jenis == 'sebagian') {
                    $data = DB::table('orders as a')->select(
                        'a.*',
                        'c.*',
                        'd.*',
                        'a.id as order_id',
                        DB::raw("(SELECT count(id) FROM orderdetails b WHERE b.order_id=a.id) as total_count"),
                        DB::raw("(SELECT count(id) FROM orderdetails b WHERE b.order_id=a.id AND complete IS NOT NULL AND complete!='') as complete_count")
                    )->leftJoin('units as c', 'a.unit_id', '=', 'c.id')->leftJoin('employees as d', 'a.employee_id', '=', 'd.id')->havingRaw('total_count>complete_count')->havingRaw('complete_count != 0')->get();
                } else {
                    $data = DB::table('orders as a')->select(
                        'a.*',
                        'c.*',
                        'd.*',
                        'a.id as order_id',
                        DB::raw("(SELECT count(id) FROM orderdetails b WHERE b.order_id=a.id) as total_count"),
                        DB::raw("(SELECT count(id) FROM orderdetails b WHERE b.order_id=a.id AND complete IS NOT NULL AND complete!='') as complete_count")
                    )->leftJoin('units as c', 'a.unit_id', '=', 'c.id')->leftJoin('employees as d', 'a.employee_id', '=', 'd.id')->havingRaw('complete_count=0')->get();
                }
            } else {
                $data = [];
                if ($jenis == "terpenuhi") {

                    $data = DB::table('orders as a')->select(
                        'a.*',
                        'c.*',
                        'd.*',
                        'a.id as order_id',
                        DB::raw("(SELECT count(id) FROM orderdetails b WHERE b.order_id=a.id) as total_count"),
                        DB::raw("(SELECT count(id) FROM orderdetails b WHERE b.order_id=a.id AND complete IS NOT NULL AND complete!='') as complete_count")
                    )->leftJoin('units as c', 'a.unit_id', '=', 'c.id')->leftJoin('employees as d', 'a.employee_id', '=', 'd.id')->havingRaw('total_count=complete_count')
                        ->where('a.unit_id', session('employee_unit_id'))->get();
                } elseif ($jenis == 'sebagian') {
                    $data = DB::table('orders as a')->select(
                        'a.*',
                        'c.*',
                        'd.*',
                        'a.id as order_id',
                        DB::raw("(SELECT count(id) FROM orderdetails b WHERE b.order_id=a.id) as total_count"),
                        DB::raw("(SELECT count(id) FROM orderdetails b WHERE b.order_id=a.id AND complete IS NOT NULL AND complete!='') as complete_count")
                    )->leftJoin('units as c', 'a.unit_id', '=', 'c.id')->leftJoin('employees as d', 'a.employee_id', '=', 'd.id')->havingRaw('total_count>complete_count')->havingRaw('complete_count != 0')->where('a.unit_id', session('employee_unit_id'))->get();
                } else {
                    $data = DB::table('orders as a')->select(
                        'a.*',
                        'c.*',
                        'd.*',
                        'a.id as order_id',
                        DB::raw("(SELECT count(id) FROM orderdetails b WHERE b.order_id=a.id) as total_count"),
                        DB::raw("(SELECT count(id) FROM orderdetails b WHERE b.order_id=a.id AND complete IS NOT NULL AND complete!='') as complete_count")
                    )->leftJoin('units as c', 'a.unit_id', '=', 'c.id')->leftJoin('employees as d', 'a.employee_id', '=', 'd.id')->havingRaw('complete_count=0')->where('a.unit_id', session('employee_unit_id'))->get();
                }
            }
            // else {
            //     $data = Order::where('orders.unit_id', session('employee_unit_id'))->leftJoin('units', 'orders.unit_id', '=', 'units.id')->leftJoin('employees', 'orders.employee_id', '=', 'employees.id')->get(['orders.id as order_id', 'orders.*', 'units.*', 'employees.*']);
            // }

            // if (session('tu_rt') == true || session('keuangan') == true  ) {
            //     $data = Order::leftJoin('units', 'orders.unit_id', '=', 'units.id')->leftJoin('employees', 'orders.employee_id', '=', 'employees.id')->get(['orders.id as order_id', 'orders.*', 'units.*', 'employees.*']);
            // } else {
            //     $data = Order::where('orders.unit_id', session('employee_unit_id'))->leftJoin('units', 'orders.unit_id', '=', 'units.id')->leftJoin('employees', 'orders.employee_id', '=', 'employees.id')->get(['orders.id as order_id', 'orders.*', 'units.*', 'employees.*']);
            // }

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('order_detail', function ($row) {
                    $actionBtn = '<a href="' . url('orderdetail/' . $row->order_id)  . '" class="order-detail-btn btn-primary btn-sm" >' . $row->nomor_pesanan . '</a>';

                    return $actionBtn;
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="" class="delete-btn btn-danger btn-sm" data-id="' . $row->order_id . '">Delete</a> <a href="" class="edit-btn btn-warning btn-sm" data-id="' . $row->order_id . '">Edit tgl</a>';

                    return $actionBtn;
                })
                ->addColumn('completed', function ($row) {
                    $data = Orderdetail::where('order_id', $row->order_id)->count();
                    $data_complete = Orderdetail::where('order_id', $row->order_id)->where('complete', 'Y')->count();
                    if ($data == $data_complete) {
                        $span = '<span class="bg-success p-2 text-white">Terpenuhi</span>';
                    } elseif ($data_complete != null && $data > $data_complete) {
                        $span = '<span class="bg-warning p-2 text-white">Sebagian terpenuhi</span>';
                    } else {
                        $span = '<span class="bg-danger p-2 text-white">Belum terpenuhi</span>';
                    }

                    return $span;
                })
                ->rawColumns(['order_detail', 'action', 'completed'])
                ->make(true);
        }
    }

    public function tambahPesanan(Request $request)
    {
        // $max_nomor = DB::table('mails')->whereYear('tanggal_surat', $tahun)->max('nomor_surat');
        // $tahun = Carbon::now()->format('Y');
        // $max_nomor = Order::whereYear('tanggal_pesanan', $tahun)->max('nomor_index');

        // if ($max_nomor) {

        //     $new_number = $max_nomor + 1;
        // }

        // if (!$max_nomor) {
        //     $new_number = 1;
        // }

        // $nomor_pesanan = 'UK-' . $new_number . '-' . $tahun;

        // $order = Order::create([
        //     'nomor_index' => $new_number,
        //     'nomor_pesanan' => $nomor_pesanan,
        //     'tanggal_pesanan' => Carbon::now()->toDateString(),
        //     'unit_id' => session('employee_unit_id'),
        //     'employee_id' => session('employee_id')
        // ]);

        // $nomor_pesanan_inserted = Order::where('id', $order->id)->first();
        $jenis = DB::table('ref_jenis_barang')->get();
        $goods = Good::all();
        $goods_json = $goods->toJson();
        $pegawai = DB::table('employees')->get();

        return view('order.form_pesanan', ['goods' => $goods, 'goods_json' => $goods_json, 'pegawai' => $pegawai, 'jenis' => $jenis]);
    }

    public function insertOrderDetails(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'nama_barang.*' => 'required',
                'jumlah_barang.*' => 'required',
                'satuan.*' => 'required',
                'pemesan' => 'required',


            ],

            [
                'nama_barang.*.required' => 'Nama barang harus diisi',
                'jumlah_barang.*.required' => 'Jumlah barang harus diisi',
                'satuan.*.required' => 'Satuan harus diisi',
                'pemesan.required' => 'Pemesan harus diisi',

            ]
        );

        if ($validator->fails()) {

            return redirect('tambahpesanan')
                ->withErrors($validator)
                ->withInput();
        }

        $tahun = Carbon::now()->format('Y');

        $max_nomor = Order::whereYear('tanggal_pesanan', $tahun)->max('nomor_index');

        if ($max_nomor) {

            $new_number = $max_nomor + 1;
        }

        if (!$max_nomor) {
            $new_number = 1;
        }

        $nomor_pesanan = 'UK-' . $new_number . '-' . $tahun;

        $order = Order::create([
            'nomor_index' => $new_number,
            'nomor_pesanan' => $nomor_pesanan,
            'tanggal_pesanan' => Carbon::now()->toDateString(),
            'unit_id' => session('employee_unit_id'),
            'employee_id' => $request->input('pemesan'),

        ]);


        $nama_barang = collect($request->nama_barang);
        $jumlah_barang = collect($request->jumlah_barang);
        $satuan = collect($request->satuan);
        $order_id = $order->id;

        $count_request = count($nama_barang);

        for ($i = 0; $i < $count_request; $i++) {
            Orderdetail::create([
                'nama_barang' => $nama_barang[$i],
                'jumlah_barang' => $jumlah_barang[$i],
                'satuan' => $satuan[$i],
                'order_id' => $order_id,
            ]);
        }

        $admin_phone = "087861961179";
        $message = "Pemesanan barang dengan nomor order $nomor_pesanan";
        $dataRaw = [
            'nomor_tujuan' => $admin_phone,
            'pesan' => $message,
        ];
        $data['message'] = json_encode($dataRaw);
        try {
            // $pusher->trigger('electra-channel', 'electra-event', $data, ['socket_id' => $socketId]);
            $response = Http::post('http://websocket.onsdeeapp.my.id:4141/esimpatik', [
                'message' => $data['message'],
            ]);
        } catch (\Exception $e) {
        }
        return redirect('orders')->with('success', $count_request . ' barang berhasil diinput!');
    }

    public function cancelOrder(Request $request)
    {
        $order_id = $request->order_id;

        if (Order::where('id', $order_id)->delete()) {
            $request->session()->flash('success', 'Order berhasil dihapus');
            return response()->json(['msg' => 'success']);
        }
    }

    public function orderDetail(Request $request)
    {


        $order_id = $request->route('order_id');
        $order_number = Order::find($order_id)['nomor_pesanan'];
        $itemsData = Orderdetail::where('order_id', $order_id)->get();
        $order_fullfills = Orderfullfill::where('order_id', $order_id)->orderBy('tanggal', 'desc')->get();

        // dd($itemsData);

        $items = collect();
        // foreach ($itemsData as $item) {
        //     // dd($item);

        // }

        $itemsData->each(function ($item, $key) use ($items) {
            $jml_barang_sebelumnya = Fullfill::where('order_detail_id', $item->id)->sum('jumlah');
            $items->push(collect($item)->merge(['jumlah_sebelumnya' => $jml_barang_sebelumnya]));
        });
        // dd($items);

        $previous_fullfill_array = [];
        foreach ($order_fullfills as $fullfill) {
            $goods_detail = [];
            foreach (json_decode($fullfill['orderfullfills_id']) as $f) {
                $goods_detail[] = Fullfill::select(['nama_barang', 'fullfills.jumlah', 'fullfills.satuan', 'fullfills.dipa', 'fullfills.id'])->where('fullfills.id', $f)->leftJoin('orderdetails', 'fullfills.order_detail_id', '=', 'orderdetails.id')->first();
            }
            // dd($goods_detail);
            $previous_fullfill_array[$fullfill['id']] = ['items' => $goods_detail, 'tanggal' => $fullfill['tanggal']];
        }
        // dd($previous_fullfill_array);

        // $previous_fullfill_array = [];

        // $previous_fullfill = Fullfill::leftJoin('orderdetails', 'fullfills.order_detail_id', '=', 'orderdetails.id')->where('fullfills.order_id', $order_id)->get();

        // foreach ($previous_fullfill as $previous) {
        //     $previous_fullfill_array[$previous['tanggal']][] = ['nama_barang' => $previous['nama_barang'], 'jumlah' => $previous['jumlah'], 'satuan' => $previous['satuan']];
        // }


        // dd(collect($items));


        return response()->view('order.order_detail', ['items' => collect($items), 'order_id' => $order_id, 'previous_fullfill' => $previous_fullfill_array, 'order_number' => $order_number]);
    }

    public function insertPemenuhan(Request $request)
    {
        $order_id = $request->input('order_id');
        // dd($request->all());
        $validator = Validator::make(
            $request->all(),
            [
                'tanggal_pemenuhan' => 'required',
                'jumlah_barang_pemenuhan' => [new ValidateArrayElement()],
                // 'satuan_barang_pemenuhan.*' => [new ValidateArrayElement()],
                'dipa_pemenuhan' => [new ValidateArrayElement()],


            ],

            [
                'tanggal_pemenuhan.required' => 'Nama barang harus diisi',
                // 'jumlah_barang_pemenuhan.*.required' => 'Jumlah barang harus diisi',
                // 'satuan_barang_pemenuhan.*.required' => 'Satuan harus diisi',
                // 'dipa_pemenuhan.*.required' => 'DIPA harus diisi',

            ]
        );



        if ($validator->fails()) {

            return redirect('orderdetail/' . $order_id)
                ->withErrors($validator)
                ->withInput();
        }

        // $jml_dipa_pemenuhan = collect($request->dipa_pemenuhan)->filter();
        $jml_dipa_unique = collect($request->dipa_pemenuhan)->filter()->unique()->count();

        if ($jml_dipa_unique > 1) {
            return redirect('orderdetail/' . $order_id)
                ->with('fail', 'Ada sumber dana yang berbeda')
                ->withInput();
        }


        date_default_timezone_set('Asia/Bangkok');
        $tanggal_pemenuhan = $request->tanggal_pemenuhan;
        $jumlah_barang_pemenuhan = $request->jumlah_barang_pemenuhan;
        $satuan_barang_pemenuhan = $request->satuan_barang_pemenuhan;
        $dipa_pemenuhan = $request->dipa_pemenuhan;

        $order_detail_id = $request->order_detail_id;


        // dd($order_detail_id, $jumlah_barang_pemenuhan);
        $data_count = count($jumlah_barang_pemenuhan);


        $orderfullfills_id = [];
        for ($i = 0; $i < $data_count; $i++) {
            if ($jumlah_barang_pemenuhan[$i] != null) {
                $jml_barang_sebelumnya = Fullfill::where('order_detail_id', $order_detail_id[$i])->sum('jumlah');

                $jml_barang_sekarang = $jml_barang_sebelumnya + $jumlah_barang_pemenuhan[$i];

                $data_pesanan = Orderdetail::find($order_detail_id[$i]);
                $jml_barang_pesanan = $data_pesanan->jumlah_barang;
                // dd($jml_barang_sekarang, $jml_barang_pesanan, $order_detail_id[$i]);
                if ($jml_barang_sekarang >= $jml_barang_pesanan) {
                    // dd($jml_barang_pesanan);
                    $data_pesanan->complete = 'Y';
                    $data_pesanan->save();
                }
                $pemenuhan = Fullfill::create([
                    'order_id' => $order_id,
                    'order_detail_id' => $order_detail_id[$i],
                    'jumlah' => $jumlah_barang_pemenuhan[$i],
                    'satuan' => $satuan_barang_pemenuhan[$i],
                    'dipa' => $dipa_pemenuhan[$i],
                    'tanggal' => $tanggal_pemenuhan,
                ]);

                $orderfullfills_id[] = $pemenuhan->id;
            }
        }

        $orderfullfills_id = json_encode($orderfullfills_id);

        Orderfullfill::create([
            'order_id' => $order_id,
            'orderfullfills_id' => $orderfullfills_id,
            'tanggal' => $tanggal_pemenuhan,
        ]);

        return redirect('orderdetail/' . $order_id)->with('success', 'Data berhasil diinput');
    }

    public function markAsCompleted(Request $request)
    {
        $order_detail_id = $request->route('order_detail_id');
        $order_id = $request->route('order_id');
        Orderdetail::where('id', $order_detail_id)->update(['complete' => 'Y']);
        return redirect('orderdetail/' . $order_id)->with('success', 'Data berhasil diinput');
    }

    public function cetakOrder(Request $request)
    {
        $order_id = $request->route('order_id');
        $order_data = Orderdetail::leftJoin('orders', 'orderdetails.order_id', '=', 'orders.id')->where('orderdetails.order_id', $order_id)->get();

        $pdf = PDF::loadView('order.print_order_detail', ["items" => $order_data, 'tanggal' => $order_data[0]['tanggal_pesanan']])->setPaper([0, 0, 595.276, 935.433], 'portrait');

        return $pdf->download('pesanan-' . $order_data[0]['nomor_pesanan'] . '.pdf');
    }

    public function cetakPreviousForm(Request $request)
    {
        $id = $request->key;
        $orderfullfill_data = Orderfullfill::where('orderfullfills.id', $id)->leftJoin('orders', 'orderfullfills.order_id', '=', 'orders.id')->first();

        $good = [];
        foreach (json_decode($orderfullfill_data['orderfullfills_id']) as $g) {
            $good[] = Fullfill::where('fullfills.id', $g)->leftJoin('orderdetails', 'fullfills.order_detail_id', '=', 'orderdetails.id')->first();
        }


        $order_data = [
            'nomor_pesanan' => $orderfullfill_data['nomor_pesanan'],
            'tanggal' => $orderfullfill_data['tanggal'],
            'items' => $good
        ];

        $pdf = PDF::loadView('order.print_fullfill_form', ["order_data" => $order_data, 'dipa' => $good[0]->dipa])->setPaper([0, 0, 595.276, 935.433], 'portrait');

        return $pdf->download('pemenuhan-pesanan-' . $orderfullfill_data['tanggal'] . '.pdf');
    }

    public function hapusOrder(Request $request): JsonResponse
    {
        $order_id = $request->order_id;
        Order::where('id', $order_id)->delete();
        Orderdetail::where('order_id', $order_id)->delete();
        Fullfill::where('order_id', $order_id)->delete();
        Orderfullfill::where('order_id', $order_id)->delete();

        return response()->json(['msg' => 'success']);
    }

    public function modalEditTanggal(Request $request)
    {
        $order_id = $request->order_id;
        $data_order = DB::table('orders')->find($order_id);

        return response()->json(['modal' => view('order.modal_edit_tanggal', ['data' => $data_order])->render()]);
    }

    public function editTanggalOrder(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [

                'tanggal_pesanan' => 'required',


            ],

            [

                'tanggal_pesanan.required' => 'Tanggal harus diisi',

            ]
        );

        if ($validator->fails()) {
            return redirect('orders')
                ->withErrors($validator)
                ->withInput();
        }
        // dd($validator->safe()->tanggal_pesanan, $request->order_id);
        DB::table('orders')->where('id', $request->order_id)->update(['tanggal_pesanan' => $validator->safe()->tanggal_pesanan]);
        return redirect('orders')->with('success', 'Tanggal berhasil diubah!');
        // return response()->json(['modal' => view('order.modal_edit_tanggal', ['data' => $data_order])->render()]);
    }

    public function notifikasiOrder(Request $request): JsonResponse
    {
        if (session('tu_rt') == true || session('keuangan') == true  ) {
            $data_belum_dipenuhi = DB::table('orders as a')->select(
                'a.*',
                DB::raw("(SELECT count(id) FROM orderdetails b WHERE b.order_id=a.id AND complete IS NOT NULL AND complete!='') as complete_count")
            )->havingRaw('complete_count=0')->count();
        } else {
            $data_belum_dipenuhi = DB::table('orders as a')->select(
                'a.*',
                DB::raw("(SELECT count(id) FROM orderdetails b WHERE b.order_id=a.id AND complete IS NOT NULL AND complete!='') as complete_count")
            )->havingRaw('complete_count=0')->where('a.unit_id', session('employee_unit_id'))->count();
        }
        return response()->json(['jml' => $data_belum_dipenuhi]);
    }

    public function modalCetakRegister(Request $request)
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

        return response()->json(['modal' => view('order.modal_cetak_register', ['bulan' => $bulan, 'tahun' => $tahun_array])->render()]);
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
            $data_order = DB::table('orders')->whereMonth('tanggal_pesanan', $bulan)->whereYear('tanggal_pesanan', $tahun)->leftJoin('orderdetails', 'orders.id', '=', 'orderdetails.order_id')->leftJoin('employees', 'orders.employee_id', '=', 'employees.id')->leftJoin('units', 'orders.unit_id', '=', 'units.id')->orderBy('tanggal_pesanan', 'asc')->orderBy('orders.id', 'asc')->get();


            $grouped = $data_order->mapToGroups(function ($item, $key) {
                return [$item->nomor_pesanan => $item];
            });

            // dd(count($grouped->all()['UK-6-2023']->pluck('complete')->filter()));

            return view('order.register', ["orders" => $grouped->all(), 'bulan' => $bulan_array[$bulan], 'tahun' => $tahun]);
            // $pdf = PDF::loadView('order.register', ["orders" => $grouped->all(), 'bulan' => $bulan_array[$bulan], 'tahun' => $tahun])->setPaper([0, 0, 595.276, 935.433], 'landscape');
        }
        if (!$bulan) {
            $data_order = DB::table('orders')->whereYear('tanggal_pesanan', $tahun)->leftJoin('orderdetails', 'orders.id', '=', 'orderdetails.order_id')->leftJoin('employees', 'orders.employee_id', '=', 'employees.id')->leftJoin('units', 'orders.unit_id', '=', 'units.id')->orderBy('tanggal_pesanan', 'asc')->orderBy('orders.id', 'asc')->get();


            $grouped = $data_order->mapToGroups(function ($item, $key) {
                return [$item->nomor_pesanan => $item];
            });

            // dd(count($grouped->all()['UK-6-2023']->pluck('complete')->filter()));

            // $pdf = PDF::loadView('order.register', ["orders" => $grouped->all(), 'tahun' => $tahun])->setPaper([0, 0, 595.276, 935.433], 'landscape');
            return view('order.register', ["orders" => $grouped->all(), 'tahun' => $tahun]);
        }



        // return $pdf->download('register-order' . $bulan . '-' . $tahun . '.pdf');
    }

    public function anounce()
    {
        $now = Carbon::now()->setTimeZone('Asia/Makassar');

        $hour = $now->hour;
        $time = $hour >= 6 && $hour < 14 ? 'Selamat pagi' : ($hour >= 14 && $hour < 18 ? 'Selamat sore' : 'Selamat malam');
        // $pesan = urlencode("$time Bapak Ibu, mohon mengisi daftar permintaan barang");

        // websocket
        try {

            $pesan = urlencode("$time Bapak Ibu, mohon mengisi daftar permintaan barang pada aplikasi sikreta di alamat https://sikreta.pn-negara.info atau melalui dashboard PN Negara di alamat https://pn-negara.info");

            $response = Http::get("http://websocket.onsdeeapp.my.id:4141/sikreta/$pesan");
            if ($response->getStatusCode() == 200) {

                return response()->json(['msg' => 'success']);
            } else {
                return response()->json(['msg' => 'success']);
            }
        } catch (\Exception $e) {
            return response()->json(['msg' => 'fail']);
        }
    }

    public function modalCetakOutput(Request $request)
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

        return response()->json(['modal' => view('order.modal_cetak_output', ['bulan' => $bulan, 'tahun' => $tahun_array])->render()]);
    }

    public function cetakOutput1(Request $request)
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
            $order = Fullfill::select('nama_barang', DB::raw("any_value(fullfills.satuan) as satuan"), DB::raw("count(*) as total"))->join('orderdetails', 'fullfills.order_detail_id', '=', 'orderdetails.id')->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun)->groupBy('nama_barang')->get();

            // dd(count($grouped->all()['UK-6-2023']->pluck('complete')->filter()));

            $pdf = PDF::loadView('order.output', ["order" => $order, 'bulan' => $bulan_array[$bulan], 'tahun' => $tahun])->setPaper([0, 0, 595.276, 935.433], 'landscape');
        }
        if (!$bulan) {
            $order = Fullfill::select('nama_barang', DB::raw("any_value(fullfills.satuan) as satuan"), DB::raw("count(*) as total"))->join('orderdetails', 'fullfills.order_detail_id', '=', 'orderdetails.id')->whereYear('tanggal', $tahun)->groupBy('nama_barang')->get();
            $pdf = PDF::loadView('order.output', ["order" => $order,  'tahun' => $tahun])->setPaper([0, 0, 595.276, 935.433], 'landscape');
        }



        return $pdf->download('register-output' . $bulan . '-' . $tahun . '.pdf');
    }

    public function cetakOutput(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [

                'tahun' => 'required',
                'dipa' => 'required',


            ],

            [

                'tahun.required' => 'Tahun harus diisi',
                'dipa.required' => 'DIPA harus diisi',

            ]
        );

        if ($validator->fails()) {
            return redirect('mails')
                ->withErrors($validator)
                ->withInput();
        }


        $dipa = $request->dipa;
        $bulan = $request->bulan;
        $tahun = $request->tahun;
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
        if ($bulan) {

            $order = Fullfill::select('nama_barang', DB::raw("any_value(fullfills.satuan) as satuan"), DB::raw("sum(fullfills.jumlah) as total"))->join('orderdetails', 'fullfills.order_detail_id', '=', 'orderdetails.id')->join('orders', 'fullfills.order_id', '=', 'orders.id')->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun)->where('fullfills.dipa', $dipa)->groupBy('nama_barang')->get();


            // dd(count($grouped->all()['UK-6-2023']->pluck('complete')->filter()));

            // $pdf = PDF::loadView('order.output', ["order" => $order, 'bulan' => $bulan_array[$bulan], 'tahun' => $tahun])->setPaper([0, 0, 595.276, 935.433], 'landscape');
        }
        if (!$bulan) {
            $order = Fullfill::select('nama_barang', DB::raw("any_value(fullfills.satuan) as satuan"), DB::raw("sum(fullfills.jumlah) as total"))->join('orderdetails', 'fullfills.order_detail_id', '=', 'orderdetails.id')->join('orders', 'fullfills.order_id', '=', 'orders.id')->whereYear('tanggal', $tahun)->where('fullfills.dipa', $dipa)->groupBy('nama_barang')->get();

            // $pdf = PDF::loadView('order.output', ["order" => $order,  'tahun' => $tahun])->setPaper([0, 0, 595.276, 935.433], 'landscape');
        }


        $tableHead = [
            'font' => [
                'color' => [
                    'rgb' => '0000'
                ],
                'bold' => true,
                'size' => 11
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => [
                    'rgb' => 'c0c0c0'
                ]
            ],
        ];


        $styleBorder = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => '0000'],
                ],
            ],
        ];


        $spreadsheet = new Spreadsheet();
        //get current active sheet (first sheet)
        $sheet = $spreadsheet->getActiveSheet();

        //set default font
        $spreadsheet->getDefaultStyle()
            ->getFont()
            ->setName('Arial')
            ->setSize(10);
        $spreadsheet->getActiveSheet()
            ->setCellValue('A1', "REGISTER PENGELUARAN BARANG " . $dipa);

        //merge heading
        $spreadsheet->getActiveSheet()->mergeCells("A1:D1");
        $spreadsheet->getActiveSheet()->mergeCells("A2:D2");

        // set font style
        $spreadsheet->getActiveSheet()->getStyle('A1')->getFont()->setSize(12);
        $spreadsheet->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()->getStyle('A2')->getFont()->setSize(12);
        $spreadsheet->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);


        if (!$bulan) {
            $spreadsheet->getActiveSheet()
                ->setCellValue('A2', "Tahun " . $tahun);
        } else {
            $spreadsheet->getActiveSheet()
                ->setCellValue('A2', "Bulan " . $bulan_array[$bulan] . ' ' . $tahun);
        }

        // set cell alignment
        $spreadsheet->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        //setting column width
        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(10);
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(30);
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(30);
        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(20);


        //header text
        $spreadsheet->getActiveSheet()
            ->setCellValue('A4', "Nomor")
            ->setCellValue('B4', "Nama Barang")
            ->setCellValue('C4', "Jumlah")
            ->setCellValue('D4', "Satuan");


        //set font style and background color
        $spreadsheet->getActiveSheet()->getStyle('A4:D4')->applyFromArray($tableHead);
        $spreadsheet->getActiveSheet()->getStyle('A4:D4')->applyFromArray($styleBorder);

        $spreadsheet->getActiveSheet()->getStyle('A4:D4')->getAlignment()->setWrapText(true);


        $spreadsheet->getActiveSheet()->getStyle('A4:D4')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('A4:D4')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        // dd($data_elitigasi);

        //the content
        $data_nomor = [];

        if (!$order) {

            $order = [['nomor' => '-', 'nama_barang' => '-', 'jumlah' => '-', 'satuan' => '-']];
        }

        //loop through the data
        //current row
        $styleBorder = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => '0000'],
                ],
            ],
        ];
        $row = 5;
        $i = 1;
        foreach ($order as $data) {
            $spreadsheet->getActiveSheet()
                ->setCellValue('A' . $row, $i)
                ->setCellValue('B' . $row, $data['nama_barang'])
                ->setCellValue('C' . $row, $data['total'])
                ->setCellValue('D' . $row, $data['satuan']);

            $spreadsheet->getActiveSheet()->getStyle('A' . $row . ':D' . $row)
                ->applyFromArray($styleBorder);
            $spreadsheet->getActiveSheet()->getStyle('A' . $row . ':D' . $row)->getAlignment()->setWrapText(true);
            $spreadsheet->getActiveSheet()->getStyle('A' . $row . ':D' . $row)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $spreadsheet->getActiveSheet()->getStyle('C' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $spreadsheet->getActiveSheet()->getStyle('A' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $i++;
            $row++;
        }

        // $highestRow = $spreadsheet->getActiveSheet()->getHighestRow();
        // $nextRow = $highestRow + 2;

        // $panitera = $db->table('pejabat')->where('jabatan', 'Panitera')->get()->getRowArray();
        // $spreadsheet->getActiveSheet()
        //     ->setCellValue('E' . $nextRow, 'Negara, ' . $tanggal['tanggal'])
        //     ->setCellValue('E' . ($nextRow + 1), $panitera['jabatan'])
        //     ->setCellValue('E' . ($nextRow + 5), $panitera['nama'])
        //     ->setCellValue('E' . ($nextRow + 6), 'NIP. ' . $panitera['nip']);
        // //set the header first, so the result will be treated as an xlsx file.
        // if ($jenis == 'permohonan') {
        //     $jenis_perkara = 'P';
        // } elseif ($jenis == 'gugatan') {
        //     $jenis_perkara = 'G';
        // } elseif ($jenis == 'gs') {
        //     $jenis_perkara = 'GS';
        // }ceta
        // $this->response->setContentType('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        // $this->response->setHeader('Content-Disposition', 'attachment;filename="Lap-Elitigasi-' . $jenis_perkara . '-' . $bulan . '-' . $tahun . '-' . time() . '.xlsx"');

        header("Content-Disposition: attachment; filename=Register-Pengeluaran-Barang-" . time() . ".xlsx");
        $pathToSave = 'php://output';
        //create IOFactory object
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        //save into php output
        $writer->save('php://output');
    }


    public function delete_fullfills(Request $request, $id = null, $order_id = null)
    {

        $order_detail_id = Fullfill::find($id)->order_detail_id;
        Orderdetail::where('id', $order_detail_id)->update(['complete' => ""]);
        Fullfill::find($id)->delete();
        $orderfullfill_data = Orderfullfill::where('order_id', $order_id)->get();

        $orderfullfill_data->each(function ($item, $key) use ($id) {
            // dd(json_decode($item->orderfullfills_id, true));
            if (in_array($id, json_decode($item->orderfullfills_id, true))) {
                $orderfullfill_id = json_decode($item->orderfullfills_id, true);
                $array_key = array_search($id, $orderfullfill_id);
                unset($orderfullfill_id[$array_key]);

                // dd($orderfullfill_id, $item, $array_key, $key);

                Orderfullfill::where('id', $item->id)->update(['orderfullfills_id' => json_encode($orderfullfill_id)]);
            }
        });
        return redirect('orderdetail/' . $order_id)->with('success', 'Data berhasil dihapus');
    }
}
