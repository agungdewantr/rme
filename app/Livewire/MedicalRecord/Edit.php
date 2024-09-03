<?php

namespace App\Livewire\MedicalRecord;

use App\Models\ActivityLog;
use App\Models\AllergyHistory;
use App\Models\FirstEntry;
use App\Models\IllnessHistory;
use App\Models\MedicalRecord;
use App\Models\MedicalRecordHasAllergyHistories;
use App\Models\MedicalRecordHasIllnessHistory;
use App\Models\Obstetri;
use App\Models\Patient;
use App\Models\Registration;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Toaster;

class Edit extends Component
{
    public ?MedicalRecord $medicalRecord;
    public $user_id;

    #[Validate('nullable|numeric', as: 'Gravida')]
    public $gravida;

    public $birth_description;

    #[Validate('nullable|numeric', as: 'Para')]
    public $para;

    #[Validate('nullable|date', as: 'HPHT')]
    public $hpht;

    #[Validate('nullable|numeric', as: 'Abbortion/Misscarriage')]
    public $abbortion;

    #[Validate('nullable|numeric', as: 'Hidup')]
    public $hidup;

    public $illness_history = [];
    public $allergy_history = [];
    public $main_complaints;
    public $other_history;
    public $showLab = false;
    #[Validate('nullable|date', as: 'Tanggal Pemeriksaan Lab')]
    public $date_lab;

    public $patient_awareness;

    #[Validate('nullable|numeric', as: 'Tinggi')]
    public $height;

    #[Validate('nullable|numeric', as: 'Berat')]
    public $weight;

    #[Validate('nullable|numeric', as: 'Suhu Tubuh')]
    public $body_temperature;

    #[Validate('nullable|numeric', as: 'Sistole')]
    public $sistole;

    #[Validate('nullable|numeric', as: 'Diastole')]
    public $diastole;

    #[Validate('nullable|numeric', as: 'Nadi')]
    public $pulse;

    #[Validate('nullable|numeric', as: 'Frekuensi Pernafasan')]
    public $respiratory_frequency;

    public $description;
    public $diagnose;
    public $ga;
    public $gs;
    public $crl;
    public $fl;
    public $ac;
    public $fhr;
    public $efw;
    public $bpd;

    #[Validate('nullable|date')]
    public $edd;
    public $blood_type;
    public $random_blood_sugar;
    public $hemoglobin;
    public $hbsag;
    public $hiv;
    public $syphilis;
    public $urine_reduction;
    public $urine_protein;
    #[Validate('nullable|date', as: 'Tanggal Pemeriksaan Lab')]
    public $date_lab_fe;
    public $blood_type_fe;
    public $random_blood_sugar_fe;
    public $hemoglobin_fe;
    public $hbsag_fe;
    public $hiv_fe;
    public $syphilis_fe;
    public $urine_reduction_fe;
    public $urine_protein_fe;
    public $ph;
    public $summary;

    #[Validate('nullable|date', as: 'Periksa berikutnya')]
    public $next_control;

    public $subjective_summary;
    public $objective_summary;
    public $assessment_summary;
    public $plan_summary;
    public $other_summary;
    public $firstEntry;
    public $patient_id;
    public $plan_note;
    public $other_lab;
    public $other_recipe;

    public function mount($uuid)
    {
        $medicalRecord = MedicalRecord::with('user.vaccines', 'user.patient', 'illnessHistories', 'allergyHistories', 'usgs', 'checks', 'registration', 'doctor')->where('uuid', $uuid)->first();
        $this->user_id = $medicalRecord->user->id;
        $this->medicalRecord = $medicalRecord;
        $this->gravida = $medicalRecord->gravida;
        $this->birth_description = $medicalRecord->birth_description;
        $this->para = $medicalRecord->para;
        $this->hpht = Carbon::parse($medicalRecord->hpht)->format('d-m-Y');
        $this->abbortion = $medicalRecord->abbortion;
        $this->hidup = $medicalRecord->hidup;
        $this->illness_history = $medicalRecord->illnessHistories->pluck('name');
        $this->allergy_history = $medicalRecord->allergyHistories->pluck('name');
        $this->main_complaints = $medicalRecord->registration->complaints ?? NULL;
        $this->other_history = $medicalRecord->other_history;
        $this->patient_awareness = $medicalRecord->patient_awareness;
        $this->height = $medicalRecord->height;
        $this->weight = $medicalRecord->weight;
        $this->body_temperature = $medicalRecord->body_temperature;
        $this->sistole = $medicalRecord->sistole;
        $this->diagnose = $medicalRecord->diagnose;
        $this->diastole = $medicalRecord->diastole;
        $this->pulse = $medicalRecord->pulse;
        $this->respiratory_frequency = $medicalRecord->respiratory_frequency;
        $this->description = $medicalRecord->description;
        $this->summary = $medicalRecord->summary;
        $this->ga = $medicalRecord->ga;
        $this->gs = $medicalRecord->gs;
        $this->crl = $medicalRecord->crl;
        $this->fl = $medicalRecord->fl;
        $this->ac = $medicalRecord->ac;
        $this->fhr = $medicalRecord->fhr;
        $this->efw = $medicalRecord->efw;
        $this->bpd = $medicalRecord->bpd;
        $this->edd = Carbon::parse($medicalRecord->edd)->format('d-m-Y');
        $this->blood_type = $medicalRecord->blood_type;
        $this->random_blood_sugar = $medicalRecord->random_blood_sugar;
        $this->hemoglobin = $medicalRecord->hemoglobin;
        $this->hbsag = $medicalRecord->hbsag;
        $this->hiv = $medicalRecord->hiv;
        $this->syphilis = $medicalRecord->syphilis;
        $this->urine_protein = $medicalRecord->urine_protein;
        $this->urine_reduction = $medicalRecord->urine_reduction;
        $this->ph = $medicalRecord->ph;
        $this->next_control = $medicalRecord->next_control;
        $this->subjective_summary = $medicalRecord->subjective_summary;
        $this->objective_summary = $medicalRecord->objective_summary;
        $this->assessment_summary = $medicalRecord->assessment_summary;
        $this->plan_summary = $medicalRecord->plan_summary ?? "Periksa Berikutnya: {$medicalRecord->next_control}";
        $this->other_summary = $medicalRecord->other_summary;
        $this->plan_note = $medicalRecord->plan_note;
        $this->date_lab = $medicalRecord->date_lab ? Carbon::parse($medicalRecord->date_lab)->format('d-m-Y') : NULL;
        $this->showLab = $medicalRecord->date_lab ? true : false;
        $this->other_lab = $medicalRecord->other_lab;
        $this->other_recipe = $medicalRecord->other_recipe;

        $interpretation_childbirth = Carbon::parse($this->hpht)->addDays(280)->format('d/m/Y');
        $intervalWeeks = floor(Carbon::now()->diffInWeeks(Carbon::parse($medicalRecord->hpht)));
        $intervalDays = floor(Carbon::now()->diffInDays(Carbon::parse($medicalRecord->hpht))) % 7;
        $hpht = Carbon::parse($medicalRecord->hpht)->format('d/m/Y');
        // $this->subjective_summary = $medicalRecord->subjective_summary ?? "G:{$medicalRecord->gravida}; P:{$medicalRecord->para}; A:{$medicalRecord->abbortion}; H: {$medicalRecord->hidup};\nHPHT: {$hpht}\nTafsiran: {$interpretation_childbirth}\nUsia: {$intervalWeeks} minggu {$intervalDays} hari\n----------\n";
        $this->patient_id = Patient::where('user_id', $this->medicalRecord->user_id)->first()->id;
        $this->firstEntry = FirstEntry::with('patient.user.vaccines', 'patient')->where('patient_id', $this->patient_id)->orderBy('id', 'desc')->first();
        if($this->firstEntry){
            $this->date_lab_fe = $this->firstEntry->date_lab;
            $this->blood_type_fe = $this->firstEntry->blood_type;
            $this->random_blood_sugar_fe = $this->firstEntry->random_blood_sugar;
            $this->hemoglobin_fe = $this->firstEntry->hemoglobin;
            $this->hbsag_fe = $this->firstEntry->hbsag;
            $this->hiv_fe = $this->firstEntry->hiv;
            $this->syphilis_fe = $this->firstEntry->syphilis;
            $this->urine_reduction_fe = $this->firstEntry->urine_reduction;
            $this->urine_protein_fe = $this->firstEntry->urine_protein;
        }
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
        if (auth()->user()->role_id == 2 && $medicalRecord->registration && $medicalRecord->registration->status == 'Pemeriksaan') {
        $this->objective_summary =  "TD:{$medicalRecord->sistole}/{$medicalRecord->diastole}; \nBB:{$medicalRecord->weight} kg; \nTB:{$medicalRecord->height} cm; \nS: {$medicalRecord->body_temperature}; \nN: {$medicalRecord->pulse}; \nBMI/BMI Status: {$imt}/{$imtStatus}";
        $this->subjective_summary = $medicalRecord->subjective_summary ?? $this->firstEntry->main_complaint;
        }else{
            $this->subjective_summary = $medicalRecord->subjective_summary;
            $this->objective_summary = $medicalRecord->objective_summary;
        }
        // $this->objective_summary = $medicalRecord->objective_summary ?? "TB: {$medicalRecord->height}; BB: {$medicalRecord->weight}\n{$imt} - {$imtStatus}\n{$this->sistole}/{$this->diastole} mmHg\n----------\n";
        // $this->assessment_summary = $medicalRecord->assessment_summary ?? "Diagnosa: {$this->diagnose}";
    }

    public function render()
    {
        $this->authorize('update', $this->medicalRecord);
        $datetime1 = new DateTime($this->medicalRecord->user->patient->dob ?? date(now())); //convert dob to datetime
        $datetime2 = new DateTime();
        $interval = $datetime1->diff($datetime2);

        $datetime1 = new DateTime($this->medicalRecord->user->patient->husbands_birth_date);
        $datetime2 = new DateTime();
        $age_husband = $datetime1->diff($datetime2);

        if (auth()->user()->role_id == 2) {
            return view('livewire.medical-record.edit-doctor', [
                'oldMedicalRecords' => MedicalRecord::with('nurse', 'firstEntry', 'registration','registration.branch', 'doctor', 'usgs', 'checks', 'actions', 'drugMedDevs', 'laborate')
                    ->where('user_id',  $this->medicalRecord->user->id)->latest()->get(),
                'age' => $interval,
                'age_husband' => $age_husband,
                'logs' => ActivityLog::where('model_id', $this->medicalRecord->id)->where('model', 'MedicalRecord')->latest()->get(),
                'obstetri' => Obstetri::where('patient_id', $this->patient_id)->orderBy('id', 'asc')->get(),
                'firstEntry' => $this->firstEntry,
            ]);
        }
        return view('livewire.medical-record.edit', [
            'age' => $interval,
            'age_husband' => $age_husband,
            'logs' => ActivityLog::where('model_id', $this->medicalRecord->id)->where('model', 'MedicalRecord')->latest()->get(),
            'obstetri' => Obstetri::where('patient_id', $this->patient_id)->orderBy('id', 'asc')->get(),
            'firstEntry' => $this->firstEntry,
            'medicalRecords' => MedicalRecord::with('nurse', 'firstEntry', 'registration', 'registration.branch','doctor', 'usgs', 'checks', 'actions', 'drugMedDevs', 'laborate')->where('user_id', empty($this->user_id) ? 0 : $this->user_id)->latest()->get()

        ]);
    }

    public function save()
    {
        $this->date_lab =  $this->date_lab ?  str_replace('/', '-', $this->date_lab) : NULL;
        $this->hpht = $this->hpht ? str_replace('/', '-', $this->hpht) : NULL;
        $this->edd = $this->edd ? str_replace('/', '-', $this->edd) : NULL;
        $this->next_control = $this->next_control ? str_replace('/','-', $this->next_control) : NULL;

        $this->validate();
        $this->authorize('update', $this->medicalRecord);
        $medicalRecord = MedicalRecord::find($this->medicalRecord->id);
        $registration = Registration::find($this->medicalRecord->registration_id);
        // if (!$this->next_control && auth()->user()->role->id == 2) {
        //     Toaster::error('Form Periksa Berikutnya wajib diisi');
        //     return;
        // }
        if($this->showLab && !$this->date_lab){
            Toaster::error('Tanggal Pemeriksaan wajib diisi jika anda mengisi data lab');
            return;
        }
        if($this->showLab == false && $this->date_lab){
            $this->date_lab = NULL;
        }
        try {
            DB::beginTransaction();
            $medicalRecord->gravida = $this->gravida;
            $medicalRecord->para = $this->para;
            $medicalRecord->abbortion = $this->abbortion;
            $medicalRecord->hidup = $this->hidup;
            $medicalRecord->hpht = $this->hpht ? Carbon::parse($this->hpht)->toDateString() : null;
            $medicalRecord->birth_description = $this->birth_description;
            $medicalRecord->other_history = $this->other_history;
            $medicalRecord->patient_awareness = $this->patient_awareness;
            $medicalRecord->height = $this->height;
            $medicalRecord->weight = $this->weight;
            $medicalRecord->body_temperature = $this->body_temperature;
            $medicalRecord->sistole = $this->sistole;
            $medicalRecord->diastole = $this->diastole;
            $medicalRecord->pulse = $this->pulse;
            $medicalRecord->respiratory_frequency = $this->respiratory_frequency;
            $medicalRecord->description = $this->description;
            $medicalRecord->diagnose = $this->diagnose;
            $medicalRecord->summary = $this->summary;
            $medicalRecord->ga = $this->ga;
            $medicalRecord->gs = $this->gs;
            $medicalRecord->crl = $this->crl;
            $medicalRecord->fl = $this->fl;
            $medicalRecord->ac = $this->ac;
            $medicalRecord->fhr = $this->fhr;
            $medicalRecord->efw = $this->efw;
            $medicalRecord->bpd = $this->bpd;
            $medicalRecord->edd = $this->edd ? Carbon::parse($this->edd)->toDateString() : null;
            $medicalRecord->blood_type = $this->blood_type;
            $medicalRecord->random_blood_sugar = $this->random_blood_sugar;
            $medicalRecord->hemoglobin = $this->hemoglobin;
            $medicalRecord->hbsag = $this->hbsag;
            $medicalRecord->hiv = $this->hiv;
            $medicalRecord->syphilis = $this->syphilis;
            $medicalRecord->urine_protein = $this->urine_protein;
            $medicalRecord->urine_reduction = $this->urine_reduction;
            $medicalRecord->ph = $this->ph;
            $medicalRecord->next_control = $this->next_control ? Carbon::parse($this->next_control)->toDateString() : null;
            $medicalRecord->subjective_summary = $this->subjective_summary;
            $medicalRecord->objective_summary = $this->objective_summary;
            $medicalRecord->assessment_summary = $this->assessment_summary;
            $medicalRecord->plan_summary = $this->plan_summary;
            $medicalRecord->date_lab = $this->date_lab ? Carbon::parse($this->date_lab)->format('Y-m-d') : NULL;
            $medicalRecord->is_lab = $this->showLab;
            $medicalRecord->plan_note = $this->plan_note;
            $medicalRecord->other_summary = $this->other_summary;
            $medicalRecord->other_lab = $this->other_lab;
            $medicalRecord->other_recipe = $this->other_recipe;
            if ($medicalRecord->doctor_id == null && auth()->user()->role_id == 2) {
                $medicalRecord->doctor_id = auth()->user()->getAuthIdentifier();
            }
            if (auth()->user()->role_id == 2 && $registration && $registration->status == 'Pemeriksaan') {
                $registration->status = 'Kasir';
                $registration->save();

                // $next_booking = Registration::whereUserId($this->medicalRecord->user_id)->whereStatus('Administrasi')->first();
                // if ($next_booking) {
                //     $next_booking->date = Carbon::parse($this->next_control);
                //     $next_booking->save();
                // }
            }
            $medicalRecordDirtyAttributes = $medicalRecord->getDirty();
            $medicalRecord->save();

            if($this->blood_type &&  $this->blood_type != ''){
                $this->medicalRecord->user->patient->blood_type = $this->blood_type;
                $this->medicalRecord->user->patient->save();
            }
            // if ($registration) {
            //     $registration->complaints = $this->main_complaints;
            //     $registration->save();
            // }

            if (auth()->user()->role_id != 2) {
                MedicalRecordHasIllnessHistory::where('medical_record_id', $this->medicalRecord->id)->delete();
                MedicalRecordHasAllergyHistories::where('medical_record_id', $this->medicalRecord->id)->delete();
                foreach ($this->illness_history as $ih) {
                    if (!$illness_history = IllnessHistory::where('name', 'ilike', $ih)->first()) {
                        $illness_history = new IllnessHistory();
                        $illness_history->name = $ih;
                        $illness_history->save();
                    }

                    $medicalRecordHasIllnessHistory = new MedicalRecordHasIllnessHistory();
                    $medicalRecordHasIllnessHistory->medical_record_id = $this->medicalRecord->id;
                    $medicalRecordHasIllnessHistory->illness_history_id = $illness_history->id;
                    $medicalRecordHasIllnessHistory->save();
                }

                foreach ($this->allergy_history as $ah) {
                    if (!$allergy_history = AllergyHistory::where('name', 'ilike', $ah)->first()) {
                        $allergy_history = new AllergyHistory();
                        $allergy_history->name = $ah;
                        $allergy_history->save();
                    }

                    $medicalRecordHasAllergyHistory = new MedicalRecordHasAllergyHistories();
                    $medicalRecordHasAllergyHistory->medical_record_id = $this->medicalRecord->id;
                    $medicalRecordHasAllergyHistory->allergy_history_id = $allergy_history->id;
                    $medicalRecordHasAllergyHistory->save();
                }
            }

            if (!empty($medicalRecordDirtyAttributes)) {
                // Log the changes to an audit table
                $attributeChanged = collect();
                foreach ($medicalRecordDirtyAttributes as $attribute => $newValue) {
                    $oldValue = $this->medicalRecord->getOriginal($attribute); // Get the original value
                    // Log the change with attribute name, old value, and new value
                    $attributeChanged->push($attribute . ' dari ' . $oldValue . ' ke ' . $newValue);
                }
                $log = new ActivityLog();
                $log->author = auth()->user()->name;
                $log->model = 'MedicalRecord';
                $log->model_id = $this->medicalRecord->id;
                $log->log = 'Mengubah rekam medis pada isian ' . $attributeChanged->join(', ');
                $log->save();
            }
            DB::commit();
            Toaster::success('Rekam Medis berhasil disimpan');
            return $this->redirectRoute('dashboard', navigate: true);
        } catch (\Throwable $th) {
            DB::rollback();
            dd($th);
            Toaster::error('Gagal simpan, silakan coba beberapa saat lagi');
        }
    }

    public function updateLabFirstEntry()
    {
        $this->date_lab_fe =  $this->date_lab_fe ?  str_replace('/', '-', $this->date_lab_fe) : NULL;

        try {
            DB::beginTransaction();
            $this->firstEntry->date_lab = Carbon::parse($this->date_lab_fe)->format('Y-m-d');
            $this->firstEntry->blood_type = $this->blood_type_fe;
            $this->firstEntry->random_blood_sugar = $this->random_blood_sugar_fe;
            $this->firstEntry->hemoglobin = $this->hemoglobin_fe;
            $this->firstEntry->hbsag = $this->hbsag_fe;
            $this->firstEntry->hiv = $this->hiv_fe;
            $this->firstEntry->syphilis = $this->syphilis_fe;
            $this->firstEntry->urine_reduction = $this->urine_reduction_fe;
            $this->firstEntry->urine_protein = $this->urine_protein_fe;
            $this->firstEntry->save();

            DB::commit();
            Toaster::success('Hasil Lab berhasil disimpan');
            return;
        } catch (\Throwable $th) {
            Toaster::error('Hasil Lab berhasil disimpan');
            DB::rollback();
            dd($th);
            Toaster::error('Gagal simpan, silakan coba beberapa saat lagi');
        }
    }
}
