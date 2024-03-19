<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Good;

class Modaleditbarang extends Component
{
    public $showEditModal = false;
    public $data;
    protected $listeners = ['showEditModal'];
    public function render()
    {
        return view('livewire.modaleditbarang');
    }

    public function showEditModal($value)
    {
        $this->showEditModal = $value['show_modal'];
        $this->data = Good::find($value['goods_id']);
        // dd($this->data);
    }

    public function closeEditModal()
    {
        $this->showEditModal = false;
    }
}
