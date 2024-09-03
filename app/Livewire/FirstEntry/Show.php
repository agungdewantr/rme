<?php

namespace App\Livewire\FirstEntry;

use App\Models\ActivityLog;
use App\Models\AllergyHistory;
use App\Models\FirstEntry;
use App\Models\IllnessHistory;
use App\Models\MedicalRecord;
use DateTime;
use Livewire\Component;

class Show extends Component
{
    public ?FirstEntry $firstEntry;
    public function mount($uuid)
    {
        $firstEntry = FirstEntry::with([
            'patient' => [
                'user' => [
                    'vaccines'
                ],
                'obstetri' => function ($query) {
                    $query->orderBy('id', 'asc');
                }
            ],
        ])->where('uuid', $uuid)->first();
        $this->firstEntry = $firstEntry;
    }
    public function render()
    {
        $this->authorize('view', $this->firstEntry);
        $datetime1 = new DateTime($this->firstEntry->patient->dob);
        $datetime2 = new DateTime();
        $interval = $datetime1->diff($datetime2);

        $datetime1 = new DateTime($this->firstEntry->patient->husbands_birth_date);
        $datetime2 = new DateTime();
        $age_husband = $datetime1->diff($datetime2);
        return view('livewire.first-entry.show', [
            'age' => $interval,
            'age_husband' => $age_husband,
            'logs' => ActivityLog::where('model_id', $this->firstEntry->id)->where('model', 'FirstEntry')->latest()->get(),
            'medicalRecords' => MedicalRecord::with('nurse', 'firstEntry', 'registration', 'registration.branch','doctor', 'usgs', 'checks', 'actions', 'drugMedDevs', 'laborate')->where('user_id', empty($this->firstEntry->patient->user_id) ? 0 : $this->firstEntry->patient->user_id)->latest()->get()

        ]);
    }
}
