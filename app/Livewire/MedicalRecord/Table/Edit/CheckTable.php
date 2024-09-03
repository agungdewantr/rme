<?php

namespace App\Livewire\MedicalRecord\Table\Edit;

use App\Models\MedicalRecord;
use App\Models\Vaccine;
use Livewire\Attributes\On;
use Livewire\Component;

class CheckTable extends Component
{
    public $medical_record_id;

    public function mount($medical_record_id)
    {
        $this->medical_record_id = $medical_record_id;
    }

    public function render()
    {
        return view('livewire.medical-record.table.edit.check-table', [
            'medicalRecord' => MedicalRecord::with('checks')->whereId($this->medical_record_id)->first()
        ]);
    }

    #[On('check-table-edit-refresh')]
    public function refresh()
    {
    }

    public function delete($id)
    {
        Vaccine::where('id', $id)->delete();
        $this->dispatch('check-table-refresh');
    }
}
