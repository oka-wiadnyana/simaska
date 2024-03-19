<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Buttontambah extends Component
{

    public function render()
    {
        return view('livewire.buttontambah');
    }

    public function showModal()
    {
        $this->emit('showModal', true);
    }
}
