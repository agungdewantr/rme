<?php

namespace App\Livewire\MedicalRecord;

use DateTime;
use Carbon\Carbon;
use Livewire\Component;
use App\Models\ActivityLog;
use App\Models\FirstEntry;
use App\Models\MedicalRecord;
use App\Models\Obstetri;
use App\Models\Patient;

class Show extends Component
{
    public ?MedicalRecord $medicalRecord;

    public $plan_summary;
    public $objective_summary;
    public $subjective_summary;
    public $assessment_summary;
    public $firstEntry;
    public $patient_id;
    public $user;

    public function mount($uuid)
    {
        $medicalRecord = MedicalRecord::with('user.vaccines', 'user.patient', 'illnessHistories', 'allergyHistories', 'usgs', 'checks')->where('uuid', $uuid)->first();
        $this->user = $medicalRecord->user;
        $this->medicalRecord = $medicalRecord;
        $this->plan_summary = $medicalRecord->plan_summary ?? "Periksa Berikutnya: {$medicalRecord->next_control}";

        $interpretation_childbirth = Carbon::parse($medicalRecord->hpht)->addDays(280)->format('d/m/Y');
        $this->patient_id = Patient::where('user_id', $medicalRecord->user_id)->first()->id;
        $this->firstEntry = FirstEntry::with('patient.user.vaccines', 'patient')->where('patient_id',$this->patient_id)->orderBy('id','desc')->first();
        $intervalWeeks = floor(Carbon::now()->diffInWeeks(Carbon::parse($this->firstEntry->hpht)));
        $intervalDays = floor(Carbon::now()->diffInDays(Carbon::parse($this->firstEntry->hpht))) % 7;
        $hpht = Carbon::parse($this->firstEntry->hpht)->format('d/m/Y');

        try {
            $imt = number_format($medicalRecord->weight / pow($medicalRecord->height / 100, 2), '0', ',', '.');
        } catch (\Throwable $th) {
            $imt = 0;
        }
        if ($imt >= 40.0) {
            $imtStatus = 'Obese Class III';
        } elseif (
            $imt >= 35.0 &&
            $imt <= 39.99
        ) {
            $imtStatus = 'Obese Class II';
        } elseif (
            $imt >= 30.0 &&
            $imt <= 34.99
        ) {
            $imtStatus = 'Obese Class I';
        } elseif (
            $imt >= 25.0 &&
            $imt <= 29.99
        ) {
            $imtStatus = 'Overweight';
        } elseif (
            $imt >= 18.5 &&
            $imt <= 24.99
        ) {
            $imtStatus = 'Normal';
        } elseif (
            $imt >= 17.0 &&
            $imt <= 18.49
        ) {
            $imtStatus = 'Underweight';
        } elseif (
            $imt >= 16.0 &&
            $imt <= 16.99
        ) {
            $imtStatus = 'Severely Underweight';
        } else {
            $imtStatus = 'Very Severely Underweight';
        }
        $this->subjective_summary = $medicalRecord->subjective_summary ?? "G:{$medicalRecord->gravida}; P:{$medicalRecord->para}; A:{$medicalRecord->abbortion}; H: {$medicalRecord->hidup};\nHPHT: {$hpht}\nTafsiran: {$interpretation_childbirth}\nUsia: {$intervalWeeks} minggu {$intervalDays} hari\n----------\n";
        $this->objective_summary = $medicalRecord->objective_summary ?? "TB: {$medicalRecord->height}; BB: {$medicalRecord->weight}\n{$imt} - {$imtStatus}\n{$medicalRecord->sistole}/{$medicalRecord->diastole} mmHg\n----------\n";
        $this->assessment_summary = $medicalRecord->assessment_summary ?? "Diagnosa: {$medicalRecord->diagnose}";
    }
    public function render()
    {
        $this->authorize('view', $this->medicalRecord);
        $datetime1 = new DateTime($this->medicalRecord->user->patient->dob);
        $datetime2 = new DateTime();
        $interval = $datetime1->diff($datetime2);

        $datetime1 = new DateTime($this->user->patient->husbands_birth_date);
        $datetime2 = new DateTime();
        $age_husband = $datetime1->diff($datetime2);

        if (auth()->user()->role_id == 2) {
            return view('livewire.medical-record.show-doctor', [
                'age' => $interval,
                'age_husband' => $age_husband,
                'oldMedicalRecords' => MedicalRecord::with('nurse','registration','registration.branch','firstEntry', 'doctor', 'usgs', 'checks','actions','drugMedDevs','laborate')
                ->where('user_id',  $this->medicalRecord->user->id)->latest()->get(),
                'obstetri' => Obstetri::where('patient_id', $this->patient_id)->orderBy('id', 'asc')->get(),
                'logs' => ActivityLog::where('model_id', $this->medicalRecord->id)->where('model', 'MedicalRecord')->latest()->get()
            ]);
        }
        return view('livewire.medical-record.show', [
            'age' => $interval,
            'age_husband' => $age_husband,
            'logs' => ActivityLog::where('model_id', $this->medicalRecord->id)->where('model', 'MedicalRecord')->latest()->get(),
            'obstetri' => Obstetri::where('patient_id', $this->patient_id)->orderBy('id', 'asc')->get(),
            'medicalRecords' => MedicalRecord::with('nurse', 'firstEntry', 'registration', 'registration.branch','doctor', 'usgs', 'checks', 'actions', 'drugMedDevs', 'laborate')->where('user_id', empty($this->medicalRecord->user->id) ? 0 : $this->medicalRecord->user->id)->latest()->get()

        ]);
    }
}
