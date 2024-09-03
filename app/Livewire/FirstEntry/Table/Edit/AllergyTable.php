<?php

namespace App\Livewire\FirstEntry\Table\Edit;

use App\Models\FirstEntry;
use App\Models\FirstEntryHasAllergiesHistory;
use App\Models\PatientHasAllergyHistories;
use Livewire\Attributes\On;
use Livewire\Component;

class AllergyTable extends Component
{
    public $firstEntry_id;

    public function mount($firstEntry_id)
    {
        $this->firstEntry_id = $firstEntry_id;
    }
    #[On('allergy-table-refresh')]
    public function refresh()
    {
    }
    public function render()
    {
        return view('livewire.first-entry.table.edit.allergy-table', [
           'firstEntry' => FirstEntry::with('patient.allergyHistories')->where('id', $this->firstEntry_id)->first()
        ]);
    }

    public function delete($id){
        PatientHasAllergyHistories::find($id)->delete();
        $this->dispatch('refresh-first-entry-edit');
    }
}
