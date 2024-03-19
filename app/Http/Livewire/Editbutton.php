<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Editbutton extends Component
{
    public $goods_id;
    public function render()
    {
        return view('livewire.editbutton');
    }

    public function showEditModal($id)
    {
        $this->emit('showEditModal', ['goods_id' => $id, 'show_modal' => true]);
    }
}
