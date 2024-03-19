<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Akun;
use App\Models\Employee;
use App\Models\Level;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class AkunController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getAkunsData(Request $request)
    {
        $akuns = Akun::join('employees', 'akuns.employee_id', '=', 'employees.id')->leftJoin('units', 'employees.unit_id', '=', 'units.id')->leftJoin('positions', 'employees.position_id', '=', 'positions.id')->leftJoin('levels', 'akuns.level', '=', 'levels.id')->get(['akuns.id as akun_id', 'akuns.*', 'employees.*', 'units.*', 'levels.*','positions.*']);

        // dd($akuns[0]->nama_jabatan);

        return view('setting.akuns', ['akuns' => $akuns]);
    }

    public function modalTambahAkun(Request $request)
    {
        $employees = Employee::all();
        $levels = Level::all();

        return response()->json(['modal' => view('setting.modal_tambah_akun', ['employees' => $employees, 'levels' => $levels])->render()]);
    }

    public function tambahAkun(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'pegawai' => 'required',
                'username' => 'required|unique:akuns',
                'password' => 'required|confirmed',
                'level' => 'required',


            ],
            [
                'pegawai.required' => 'Nama pegawai harus diisi',
                'username.required' => 'Username harus diisi',
                'username.unique' => 'Username sudah ada',
                'password.required' => 'Password harus diisi',
                'password.confirmed' => 'Konfirmasi  password tidak sama',
                'level.required' => 'Level harus diisi',
            ]
        );

        if ($validator->fails()) {
            return redirect('akuns')
                ->withErrors($validator)
                ->withInput();
        }
        $pegawai = $request->input('pegawai');
        $username = $request->input('username');
        $password = $request->input('password');
        $level = $request->input('level');
        $hash_password = Hash::make($password);

        if (Akun::create([
            'employee_id' => $pegawai,
            'username' => $username,
            'password' => $hash_password,
            'level' => $level,
        ])) {
            return redirect('akuns')->with('success', 'Data berhasil diinput');
        }
    }

    public function hapusAkun(Request $request)
    {
        $akun_id = $request->akun_id;
        if (Akun::find($akun_id)->delete()) {
            $request->session()->flash('success', 'Data berhasil dihapus!');
            return response()->json(['success']);
        }
    }
}
