<?php

namespace App\Livewire\MedicalRecord\Table\Create;

use App\Models\TmpData;
use App\Models\Vaccine;
use Livewire\Attributes\On;
use Livewire\Component;

class VaccineTable extends Component
{
    public $user_id;

    public function mount($user_id)
    {
        $this->user_id = $user_id;
    }

    public function render()
    {
        return view('livewire.medical-record.table.create.vaccine-table', [
            'vaccines' => TmpData::whereUserId(auth()->user()->getAuthIdentifier())->whereLocation('medical-record.create')->whereFieldGroup('vaccine')->get()->groupBy('temp_id'),
            'oldVaccines' => Vaccine::whereUserId($this->user_id)->get()
        ]);
    }

    #[On('vaccine-table-refresh')]
    public function refresh()
    {
    }

    public function delete($id)
    {
        TmpData::whereTempId($id)->delete();
        $this->dispatch('vaccine-table-refresh');
    }
}
