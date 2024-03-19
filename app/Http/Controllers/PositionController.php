<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Position;
use Illuminate\Support\Facades\Validator;


class PositionController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    public function getPositionsData(Request $request)
    {
        $positions = Position::orderBy('nama_jabatan')->get();

        return view('setting/positions', ['positions' => $positions]);
    }

    public function modalTambahJabatan(Request $request)
    {

        return response()->json(['modal' => view('setting.modal_tambah_jabatan')->render()]);
    }

    public function tambahJabatan(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'nama_jabatan' => 'required',


            ],

            [
                'nama_jabatan.required' => 'Nama jabatan harus diisi',
            ]
        );

        if ($validator->fails()) {
            return redirect('positions')
                ->withErrors($validator)
                ->withInput();
        }
        $nama_jabatan = $request->nama_jabatan;
        $data_insert=!$request->is_ppnpn&&$request->is_ppnpn=='T'?[
            'nama_jabatan' => $nama_jabatan,
            
        ]:
        [
            'nama_jabatan' => $nama_jabatan,
            'is_ppnpn'=>$request->is_ppnpn
        ];


        if (Position::create($data_insert)) {
            return redirect('positions')->with('success', 'Data berhasil diinput');
        }
    }

    public function modalEditJabatan(Request $request)
    {
        $id_jabatan = $request->id_jabatan;
        $position = Position::find($id_jabatan);
        return response()->json(['modal' => view('setting.modal_edit_jabatan', ['position' => $position])->render()]);
    }

    public function editJabatan(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'nama_jabatan' => 'required',


            ],

            [
                'nama_jabatan.required' => 'Nama jabatan harus diisi',
            ]
        );

        if ($validator->fails()) {
            return redirect('positions')
                ->withErrors($validator)
                ->withInput();
        }
        $nama_jabatan = $request->nama_jabatan;
        $id_jabatan = $request->id_jabatan;

        $data_insert=!$request->is_ppnpn&&$request->is_ppnpn=='T'?[
            'nama_jabatan' => $nama_jabatan,
            
        ]:
        [
            'nama_jabatan' => $nama_jabatan,
            'is_ppnpn'=>$request->is_ppnpn
        ];

        if (Position::where('id', $id_jabatan)->update($data_insert)) {
            return redirect('positions')->with('success', 'Data berhasil diubah');
        }
    }

    public function hapusJabatan(Request $request)
    {
        $id_jabatan = $request->id_jabatan;
        if (Position::find($id_jabatan)->delete()) {
            $request->session()->flash('success', 'Data berhasil dihapus!');
            return response()->json(['success']);
        }
    }
}
