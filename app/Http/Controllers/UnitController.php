<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Unit;
use Illuminate\Support\Facades\Validator;


class UnitController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function getUnitsData(Request $request)
    {
        $units = Unit::orderBy('nama_unit')->get();

        return view('setting/units', ['units' => $units]);
    }

    public function modalTambahUnit(Request $request)
    {

        return response()->json(['modal' => view('setting.modal_tambah_unit')->render()]);
    }

    public function tambahUnit(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'nama_unit' => 'required',


            ],

            [
                'nama_unit.required' => 'Nama unit harus diisi',
            ]
        );

        if ($validator->fails()) {
            return redirect('units')
                ->withErrors($validator)
                ->withInput();
        }
        $nama_unit = $request->nama_unit;

        if (Unit::create([
            'nama_unit' => $nama_unit,

        ])) {
            return redirect('units')->with('success', 'Data berhasil diinput');
        }
    }

    public function modalEditUnit(Request $request)
    {
        $id_unit = $request->id_unit;
        $unit = Unit::find($id_unit);
        return response()->json(['modal' => view('setting.modal_edit_unit', ['unit' => $unit])->render()]);
    }

    public function editUnit(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'nama_unit' => 'required',


            ],

            [
                'nama_unit.required' => 'Nama unit harus diisi',
            ]
        );

        if ($validator->fails()) {
            return redirect('units')
                ->withErrors($validator)
                ->withInput();
        }
        $nama_unit = $request->nama_unit;
        $id_unit = $request->id_unit;

        if (Unit::where('id', $id_unit)->update([
            'nama_unit' => $nama_unit,

        ])) {
            return redirect('units')->with('success', 'Data berhasil diubah');
        }
    }

    public function hapusUnit(Request $request)
    {
        $id_unit = $request->id_unit;
        if (Unit::find($id_unit)->delete()) {
            $request->session()->flash('success', 'Data berhasil dihapus!');
            return response()->json(['success']);
        }
    }
}
