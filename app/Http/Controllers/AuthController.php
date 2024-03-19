<?php

namespace App\Http\Controllers;

use App\Models\Akun;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class AuthController extends Controller
{

    public function __construct()
    {
        $this->middleware('authValid')->except('logout');
    }

    public function login(Request $request)
    {

        return view('auth.login');
    }

    public function attemptLogin(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'username' => 'required',
                'password' => 'required',


            ],

            [
                'username.required' => 'Username harus diisi',
                'password.required' => 'Password harus diisi',

            ]
        );

        if ($validator->fails()) {
            return redirect('login')
                ->withErrors($validator)
                ->withInput();
        }

        $username = $request->username;
        $password = $request->password;

        $akun = Akun::where('username', $username)->join('employees', 'akuns.employee_id', '=', 'employees.id')->leftJoin('units', 'employees.unit_id', '=', 'units.id')->leftJoin('positions', 'employees.position_id', '=', 'positions.id')->leftJoin('levels', 'akuns.level', '=', 'levels.id')->select(['akuns.id as akun_id', 'akuns.*', 'employees.id as employee_id', 'employees.*', 'units.*', 'levels.*'])->first();


        if ($akun) {
            if (Hash::check($password, $akun->password)) {
                session(['login' => true, 'employee_name' => $akun->nama, 'employee_id' => $akun->employee_id, 'employee_position' => $akun->nama_jabatan, 'employee_unit' => $akun->nama_unit, 'employee_unit_id' => $akun->unit_id, 'employee_level' => $akun->nama_level, 'employee_nip' => $akun->nip]);
                if ($akun->nama_level == 'admin_renprog' || $akun->nama_level == 'kasubag_renprog' || $akun->nama_level == 'kabag_perencanaan' ||$akun->nama_level == 'sekretaris' || $akun->nama_level == 'wakil_ketua' || $akun->nama_level == 'ketua' ||$akun->nama_level == 'super_admin') {
                    session(['renprog' => true]);
                } else {
                    session(['renprog' => false]);
                }
                if ($akun->nama_level == 'admin_kepegawaian' || $akun->nama_level == 'kasubag_kepegawaian' || $akun->nama_level == 'kabag_perencanaan' ||$akun->nama_level == 'sekretaris' || $akun->nama_level == 'wakil_ketua' || $akun->nama_level == 'ketua' ||$akun->nama_level == 'super_admin') {
                    session(['kepegawaian' => true]);
                } else {
                    session(['kepegawaian' => false]);
                }
                if ($akun->nama_level == 'admin_tu_rt' || $akun->nama_level == 'kasubag_tu_rt' || $akun->nama_level == 'kabag_keuangan' ||$akun->nama_level == 'sekretaris' || $akun->nama_level == 'wakil_ketua' || $akun->nama_level == 'ketua' ||$akun->nama_level == 'super_admin') {
                    session(['tu_rt' => true]);
                } else {
                    session(['tu_rt' => false]);
                }
                if ($akun->nama_level == 'admin_keuangan' || $akun->nama_level == 'kasubag_keuangan' || $akun->nama_level == 'kabag_keuangan' ||$akun->nama_level == 'sekretaris' || $akun->nama_level == 'wakil_ketua' || $akun->nama_level == 'ketua' ||$akun->nama_level == 'super_admin') {
                    session(['keuangan' => true]);
                } else {
                    session(['keuangan' => false]);
                }
                if ($akun->is_atasan_langsung == 'Y'||$akun->nama_level == 'super_admin') {
                    session(['is_atasan_langsung' => true]);
                } else {
                    session(['is_atasan_langsung' => false]);
                }
                if ($akun->nama_jabatan == 'PPNPN') {
                    session(['ppnpn' => true]);
                } else {
                    session(['ppnpn' => false]);
                }

                return redirect('/dashboard')->with('success', 'Selamat datang ' . $akun->nama);
            } else {
                return redirect('/login')->with('fail', 'Password salah');
            }
        } else {
            return redirect('/login')->with('fail', 'Username salah');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->flush();
        return redirect('login');
    }
}
