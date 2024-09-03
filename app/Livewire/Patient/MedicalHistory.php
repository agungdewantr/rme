<?php

namespace App\Livewire\Patient;

use App\Models\MedicalRecord;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;

class MedicalHistory extends ModalComponent
{
    public ?MedicalRecord $medicalRecord;

    public function mount($uuid)
    {
        $this->medicalRecord = MedicalRecord::with('user.vaccines', 'user.patient', 'illnessHistories', 'allergyHistories', 'usgs', 'checks')->where('uuid', $uuid)->first();
    }
    public function render()
    {
        return view('livewire.patient.medical-history');
    }
}
