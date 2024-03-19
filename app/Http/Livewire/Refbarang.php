<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Arr;

class Refbarang extends Component
{
    public $showModal = false;
    public $inputRows = [];
    public $listeners = ['showModal', 'deleteRow'];
    public $maxId = 0;

    public function mount()
    {
        $this->inputRows[] = ['id' => 1];
    }
    public function render()
    {
        return view('livewire.refbarang');
    }

    public function showModal($value)
    {
        $this->showModal = $value;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }
    public function addRow()
    {
        $maxId = collect($this->inputRows)->max('id');

        $this->inputRows[] = ['id' => $maxId + 1];
    }

    public function deleteRow($id)
    {

        $key = Arr::where($this->inputRows, function ($value, $key) use ($id) {
            return $value['id'] == $id;
        });


        Arr::pull($this->inputRows, key($key));
    }
}
