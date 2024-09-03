<?php

namespace App\Livewire\Poli;

use Livewire\Component;
use Toaster;

class RowTable extends Component
{
    public $checkup, $iteration, $name, $is_active;
    public function mount($checkup, $iteration)
    {
        $this->checkup = $checkup;
        $this->iteration = $iteration;
        $this->name = $checkup->name;
        $this->is_active = $checkup->is_active;

    }
    public function render()
    {
        return view('livewire.poli.row-table');
    }


    public function updated($property)
    {
        if($property == 'name'){
            if($this->name == ''){
                Toaster::error('Nama tidak boleh kosong');
                return;
            }
            $this->checkup->name = $this->name;
            $this->checkup->save();
        }

        if($property == 'is_active'){
            $this->checkup->is_active = $this->is_active;
            $this->checkup->save();
        }

    }


    public function delete()
    {
        $this->checkup->delete();
        $this->dispatch('poli-edit');
    }
}
