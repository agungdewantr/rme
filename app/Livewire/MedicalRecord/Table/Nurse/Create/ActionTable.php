<?php

namespace App\Livewire\MedicalRecord\Table\Nurse\Create;

use App\Models\TmpData;
use Livewire\Attributes\On;
use Livewire\Component;

class ActionTable extends Component
{
    public function render()
    {
        return view('livewire.medical-record.table.nurse.create.action-table', [
            'actions' => TmpData::whereUserId(auth()->user()->id)->whereLocation('medical-record.create')->whereFieldGroup('action')->get()->groupBy('temp_id')
        ]);
    }

    #[On('refresh-action-table')]
    public function refesh()
    {
    }

    public function delete($temp_id)
    {
        TmpData::whereTempId($temp_id)->delete();
        $this->dispatch('$refresh');
    }
}
