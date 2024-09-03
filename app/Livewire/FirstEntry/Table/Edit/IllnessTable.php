<?php

namespace App\Livewire\FirstEntry\Table\Edit;

use App\Models\FirstEntry;
use App\Models\FirstEntryHasIllnessHistory;
use App\Models\PatientHasAllergyHistories;
use App\Models\PatientHasIllnessHistories;
use Livewire\Attributes\On;
use Livewire\Component;

class IllnessTable extends Component
{
    public $firstEntry_id;

    public function mount($firstEntry_id)
    {
        $this->firstEntry_id = $firstEntry_id;
    }

    #[On('illness-table-refresh')]
    public function refresh()
    {
    }
    public function render()
    {
        return view('livewire.first-entry.table.edit.illness-table',[
            'firstEntry' => FirstEntry::with('patient.illnessHistories')->where('id', $this->firstEntry_id)->first()
        ]);
    }

    public function delete($id){
        $data = PatientHasIllnessHistories::find($id);
        $data->delete();
        $this->dispatch('refresh-first-entry-edit');
    }
}
