<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Position;
use App\Models\Unit;
use App\Models\Rank;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;

class EmployeeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    public function getEmployeesData(Request $request)
    {
        $employees = Employee::join('positions', 'employees.position_id', '=', 'positions.id')
            ->join('units', 'employees.unit_id', '=', 'units.id')
            ->leftJoin('ranks', 'employees.golongan', '=', 'ranks.id')
            ->get(['employees.id as id_pegawai', 'employees.*', 'positions.*', 'units.*', 'ranks.*', 'ranks.golongan as golongan_pegawai']);
        $data_pegawai = [];
        foreach ($employees as $employee) {
            if ($employee->tgl_awal_mk != null) {
                $potongan_mk=$employee->potongan_mk??0;
                $tgl_awal_masa_kerja = Carbon::parse($employee->tgl_awal_mk);
                $diffYear = $tgl_awal_masa_kerja->diffInYears();
                $diffMonth = $tgl_awal_masa_kerja->diffInMonths() % 12;
                $masa_kerja =  $diffYear-$potongan_mk . ' tahun ' . $diffMonth . ' bulan';
            } else {
                $masa_kerja =  "";
            }

            $data_pegawai[] = collect($employee)->merge(['masa_kerja' => $masa_kerja]);
        }

        
        return view('setting.employees', ['employees' => $data_pegawai]);
    }

    public function modalTambahPegawai(Request $request)
    {
        $positions = Position::all();
        $units = Unit::all();
        $ranks = Rank::all();
        return response()->json(['modal' => view('setting.modal_tambah_pegawai', ['positions' => $positions, 'units' => $units, 'ranks' => $ranks])->render()]);
    }

    public function tambahPegawai(Request $request)
    {

        $is_ppnpn=Position::where('id',request('jabatan'))->first();
      
        
        $validator = Validator::make(
            $request->all(),
            [
                'nama_pegawai' => 'required',
                'nip' => 'required',
                'jabatan' => 'required',
                'unit' => 'required',
                'golongan' => Rule::requiredIf($is_ppnpn?->is_ppnpn==null),
                'nomor_hp' => 'required',
                'is_atasan_langsung' => 'required',
                'tgl_awal_mk' => Rule::requiredIf($is_ppnpn?->is_ppnpn==null),

            ],

            [
                'nama_pegawai.required' => 'Nama pegawai harus diisi',
                'nip.required' => 'NIP harus diisi',
                'jabatan.required' => 'Jabatan harus diisi',
                'unit.required' => 'Unit harus diisi',
                'golongan.required' => 'Golongan harus diisi',
                'nomor_hp.required' => 'Nomor HP harus diisi',
                'is_atasan_langsung.required' => 'Pilihan atasan langsung harus diisi',
                'tgl_awal_mk.required' => 'Tanggal awal masa kerja harus diisi',
            ]
        );

        if ($validator->fails()) {
            return redirect('employees')
                ->withErrors($validator->messages())
                ->withInput();
        }
        $nama = $request->input('nama_pegawai');
        $nip = $request->input('nip');
        $position_id = $request->input('jabatan');
        $unit_id = $request->input('unit');
        $golongan = $request->input('golongan');
        $nomor_hp = $request->input('nomor_hp');
        $is_atasan_langsung = $request->input('is_atasan_langsung');
        $tgl_awal_mk = $request->input('tgl_awal_mk');

        $data_insert = compact('nama', 'nip', 'position_id', 'unit_id', 'golongan', 'nomor_hp', 'is_atasan_langsung', 'tgl_awal_mk');

        if (Employee::create($data_insert)) {
            return redirect('employees')->with('success', 'Data berhasil diinput');
        }
    }

    public function modalEditPegawai(Request $request)
    {
        $id_pegawai = $request->id_pegawai;
        $positions = Position::all();
        $units = Unit::all();
        $ranks = Rank::all();
        $pegawai = Employee::find($id_pegawai);
        return response()->json(['modal' => view('setting.modal_edit_pegawai', ['positions' => $positions, 'units' => $units, 'ranks' => $ranks, 'pegawai' => $pegawai])->render()]);
    }

    public function editPegawai(Request $request)
    {
        $is_ppnpn=Position::where('id',request('jabatan'))->first();
        $validator = Validator::make(
            $request->all(),
            [
                'nama_pegawai' => 'required',
                'nip' => 'required',
                'jabatan' => 'required',
                'unit' => 'required',
                'golongan' => Rule::requiredIf($is_ppnpn?->is_ppnpn==null),
                'nomor_hp' => 'required',
                'is_atasan_langsung' => 'required',
                'tgl_awal_mk' => Rule::requiredIf($is_ppnpn?->is_ppnpn==null),

            ],

            [
                'nama_pegawai.required' => 'Nama pegawai harus diisi',
                'nip.required' => 'NIP harus diisi',
                'jabatan.required' => 'Jabatan harus diisi',
                'unit.required' => 'Unit harus diisi',
                'golongan.required' => 'Golongan harus diisi',
                'nomor_hp.required' => 'Nomor HP harus diisi',
                'is_atasan_langsung.required' => 'Pilihan atasan langsung harus diisi',
                'tgl_awal_mk.required' => 'Tanggal awal masa kerja harus diisi',
            ]
        );

        if ($validator->fails()) {
            return redirect('employees')
                ->withErrors($validator)
                ->withInput();
        }
        $nama = $request->input('nama_pegawai');
        $nip = $request->input('nip');
        $position_id = $request->input('jabatan');
        $unit_id = $request->input('unit');
        $golongan = $request->input('golongan');
        $nomor_hp = $request->input('nomor_hp');
        $is_atasan_langsung = $request->input('is_atasan_langsung');
        $tgl_awal_mk = $request->input('tgl_awal_mk');
        $potongan_mk = $request->input('potongan_mk');

        $id_pegawai = $request->input('id_pegawai');

        $data_insert = compact('nama', 'nip', 'position_id', 'unit_id', 'golongan', 'nomor_hp', 'is_atasan_langsung', 'tgl_awal_mk','potongan_mk');
        if (Employee::where('id', $id_pegawai)->update($data_insert)) {
            return redirect('employees')->with('success', 'Data berhasil diubah');
        }
    }

    public function hapusPegawai(Request $request)
    {
        $id_pegawai = $request->id_pegawai;
        if (Employee::find($id_pegawai)->delete()) {
            $request->session()->flash('success', 'Data berhasil dihapus!');
            return response()->json(['success']);
        }
    }
}
