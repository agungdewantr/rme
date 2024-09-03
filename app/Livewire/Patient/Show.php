<?php

namespace App\Livewire\Patient;

use App\Models\Job;
use App\Models\MedicalRecord;
use App\Models\Patient;
use DateTime;
use Livewire\Component;

class Show extends Component
{
    public ?Patient $patient;

    public function mount(Patient $patient)
    {
        $patient->load('user', 'insurances', 'emergencyContacts');
    }

    public function render()
    {
        $this->authorize('view', $this->patient);
        $datetime1 = new DateTime($this->patient->dob);
        $datetime2 = new DateTime();
        $age_patient = $datetime1->diff($datetime2);

        $datetime1 = new DateTime($this->patient->husbands_birth_date);
        $datetime2 = new DateTime();
        $age_husband = $datetime1->diff($datetime2);
        return view('livewire.patient.show', [
            'patient' => $this->patient,
            'jobs' => Job::all(),
            'age' => $age_patient,
            'age_husband' => $age_husband,
            'lastMedicalRecord' => MedicalRecord::with('allergyHistories', 'illnessHistories')->where('user_id', $this->patient->user_id)->latest()->first(),
            'medical_record' => MedicalRecord::with('nurse', 'firstEntry', 'registration', 'registration.branch', 'doctor', 'usgs', 'checks', 'actions', 'drugMedDevs', 'laborate')->where('user_id', $this->patient->user_id)->latest()->get(),
            'emergency_contacts' => $this->patient->emergencyContacts
        ]);
    }
}
