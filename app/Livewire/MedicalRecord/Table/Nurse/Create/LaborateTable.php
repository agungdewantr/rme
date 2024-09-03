<?php

namespace App\Livewire\MedicalRecord\Table\Nurse\Create;

use App\Models\TmpData;
use Livewire\Attributes\On;
use Livewire\Component;

class LaborateTable extends Component
{
    public function render()
    {
        return view('livewire.medical-record.table.nurse.create.laborate-table',[
            'laborate' => TmpData::whereUserId(auth()->user()->id)->whereLocation('medical-record.create')->whereFieldGroup('laborate')->get()->groupBy('temp_id')
        ]);
    }

    #[On('refresh-laborate-table')]
    public function refesh()
    {
    }

    public function delete($temp_id)
    {
        TmpData::whereTempId($temp_id)->delete();
        $this->dispatch('$refresh');
    }
}
