<?php

namespace App\Livewire\MedicalRecord\Table\Nurse\Create;

use App\Models\TmpData;
use Livewire\Attributes\On;
use Livewire\Component;

class DrugTable extends Component
{
    public function render()
    {
        return view('livewire.medical-record.table.nurse.create.drug-table', [
            'drugs' => TmpData::whereUserId(auth()->user()->id)->whereLocation('medical-record.create')->whereFieldGroup('drug')->get()->groupBy('temp_id')
        ]);
    }

    #[On('refresh-drug-table')]
    public function refesh()
    {
    }

    public function delete($temp_id)
    {
        TmpData::whereTempId($temp_id)->delete();
        $this->dispatch('$refresh');
    }
}
