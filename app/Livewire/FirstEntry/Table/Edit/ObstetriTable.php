<?php

namespace App\Livewire\FirstEntry\Table\Edit;

use App\Models\Obstetri;
use Livewire\Attributes\On;
use Livewire\Component;

class ObstetriTable extends Component
{
    public $patient_id;

    #[On('obstetri-table-refresh')]
    public function refresh()
    {
    }
    public function render()
    {
        return view('livewire.first-entry.table.edit.obstetri-table',[
            'obstetri' => Obstetri::where('patient_id', $this->patient_id)->get()
        ]);
    }

}
