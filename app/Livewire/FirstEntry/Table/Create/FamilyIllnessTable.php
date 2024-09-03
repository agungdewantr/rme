<?php

namespace App\Livewire\FirstEntry\Table\Create;

use App\Models\FamilyIllnessHistory;
use App\Models\TmpData;
use Livewire\Attributes\On;
use Livewire\Component;

class FamilyIllnessTable extends Component
{
    public $patient_id;

    public function mount($patient_id)
    {
        $this->patient_id = $patient_id;
    }
    public function render()
    {
        return view('livewire.first-entry.table.create.family-illness-table', [
            'familyIllness' => TmpData::whereUserId(auth()->user()->getAuthIdentifier())->whereLocation('first-entry.create')->whereFieldGroup('familyillness')->get()->groupBy('temp_id'),
            'oldFamily' => FamilyIllnessHistory::where('patient_id',$this->patient_id)->get()
        ]);
    }

    #[On('familyillness-table-refresh')]
    public function refresh()
    {
    }
    public function delete($id)
    {
        TmpData::whereTempId($id)->delete();
        $this->dispatch('familyillness-table-refresh');
    }
}
