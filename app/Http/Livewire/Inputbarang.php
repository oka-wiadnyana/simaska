<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Inputbarang extends Component
{
    public $rowId;
    public function render()
    {
        $kode_barang = DB::table('ref_jenis_barang')->get();
        return view('livewire.inputbarang', ['ref' => $kode_barang]);
    }

    public function deleteRow($id)
    {
        $this->emit('deleteRow', $id);
    }
}
