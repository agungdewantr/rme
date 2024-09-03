<?php

namespace App\Livewire\MedicalRecord\Table\Doctor;

use App\Models\MedicalRecord;
use App\Models\MedicalRecordHasAction;
use Livewire\Attributes\On;
use Livewire\Component;

class ActionTable extends Component
{
    public $medical_record_id;

    public function mount($medical_record_id)
    {
        $this->medical_record_id = $medical_record_id;
    }

    public function render()
    {
        return view('livewire.medical-record.table.doctor.action-table', [
            'medicalRecord' => MedicalRecord::with('actions')->where('id', $this->medical_record_id)->first()
        ]);
    }

    #[On('refresh-action-table')]
    public function refesh()
    {
    }

    public function delete($id)
    {
        MedicalRecordHasAction::find($id)->delete();
        $this->dispatch('$refresh');
    }
}
