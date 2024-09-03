<?php

namespace App\Livewire\Setting\Table;

use App\Models\Clinic as ModelsClinic;
use Livewire\Attributes\On;
use Livewire\Component;

class Clinic extends Component
{
    public function render()
    {
        return view('livewire.setting.table.clinic', [
            'clinics' => ModelsClinic::all()
        ]);
    }

    #[On('clinic-refresh')]
    public function refresh()
    {
    }

    public function add()
    {
        $clinic = new ModelsClinic();
        $clinic->save();
        $this->dispatch('clinic-refresh');
    }
}
