<?php

namespace App\Livewire\MedicalRecord\Table\Doctor;

use App\Models\MedicalRecord;
use App\Models\MedicalRecordHasDrugMedDev;
use Livewire\Attributes\On;
use Livewire\Component;

class DrugTable extends Component
{
    public $medical_record_id;

    public function mount($medical_record_id)
    {
        $this->medical_record_id = $medical_record_id;
    }

    public function render()
    {
        return view('livewire.medical-record.table.doctor.drug-table', [
            'medicalRecord' => MedicalRecord::with('drugMedDevs')->where('id', $this->medical_record_id)->first()
        ]);
    }

    #[On('refresh-drug-table')]
    public function refesh()
    {
    }

    public function delete($id)
    {
        MedicalRecordHasDrugMedDev::find($id)->delete();
        $this->dispatch('$refresh');
    }
}
