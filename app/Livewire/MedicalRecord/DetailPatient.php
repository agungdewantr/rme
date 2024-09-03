<?php

namespace App\Livewire\MedicalRecord;

use App\Models\Job;
use App\Models\MedicalRecord;
use App\Models\Patient;
use DateTime;
use LivewireUI\Modal\ModalComponent;

class DetailPatient extends ModalComponent
{
    public $patient;

    public function mount($uuid)
    {
        $this->patient = Patient::with('user','familyIlnessHistories','allergyHistories','illnessHistories', 'insurances', 'emergencyContacts')->where('uuid',$uuid)->first();
    }
    public function render()
    {
        $datetime1 = new DateTime($this->patient->dob);
        $datetime2 = new DateTime();
        $age_patient = $datetime1->diff($datetime2);

        $datetime1 = new DateTime($this->patient->husbands_birth_date);
        $datetime2 = new DateTime();
        $age_husband = $datetime1->diff($datetime2);
        return view('livewire.medical-record.detail-patient',[
            'patient' => $this->patient,
            'age' => $age_patient,
            'age_husband' => $age_husband,
            'lastMedicalRecord' => MedicalRecord::with('allergyHistories', 'illnessHistories')->where('user_id', $this->patient->user_id)->latest()->first(),
            'medical_record' => MedicalRecord::with('doctor', 'nurse')->where('user_id', $this->patient->user_id)->get(),
            'emergency_contacts' => $this->patient->emergencyContacts
        ]);
    }
}
