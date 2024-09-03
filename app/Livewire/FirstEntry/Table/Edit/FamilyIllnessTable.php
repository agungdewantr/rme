<?php

namespace App\Livewire\FirstEntry\Table\Edit;

use App\Models\FamilyIllnessHistory;
use Livewire\Attributes\On;
use Livewire\Component;

class FamilyIllnessTable extends Component
{
    public $patient_id;

    public function mount($patient_id)
    {
        $this->patient_id = $patient_id;
    }

    #[On('family-ilness-table-refresh')]
    public function refresh()
    {
    }
    public function render()
    {
        return view('livewire.first-entry.table.edit.family-illness-table',[
            'familyIllness' => FamilyIllnessHistory::where('patient_id', $this->patient_id)->get()
        ]);
    }

    public function delete($id){
        FamilyIllnessHistory::find($id)->delete();
        $this->dispatch('refresh-first-entry-edit');
    }
}
