<?php

namespace App\Livewire\MedicalRecord;

use App\Models\ActivityLog;
use App\Models\AllergyHistory;
use App\Models\Check;
use App\Models\FirstEntry;
use App\Models\IllnessHistory;
use App\Models\Laborate;
use App\Models\MedicalRecord;
use App\Models\MedicalRecordHasAction;
use App\Models\MedicalRecordHasAllergyHistories;
use App\Models\MedicalRecordHasDrugMedDev;
use App\Models\MedicalRecordHasIllnessHistory;
use App\Models\Obstetri;
use App\Models\Patient;
use App\Models\Registration;
use App\Models\TmpData;
use App\Models\User;
use App\Models\Usg;
use App\Models\Vaccine;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Masmerise\Toaster\Toaster;
use Storage;

class Create extends Component
{
    public $user;
    public $registration;
    public $user_id;
    public $lastMedicalRecord;

    public $oldMedicalRecord;
    public $timestamp;

    #[Validate('nullable|numeric', as: 'Gravida')]
    public $gravida;

    public $birth_description;

    #[Validate('nullable|numeric', as: 'Para')]
    public $para;

    #[Validate('nullable|date', as: 'HPHT')]
    public $hpht;
    #[Validate('nullable|date', as: 'Tafsiran Persalinan')]
    public $interpretation_childbirth;
    public $age_childbirth;

    #[Validate('nullable|numeric', as: 'Abbortion/Misscarriage')]
    public $abbortion;

    #[Validate('nullable|numeric', as: 'Hidup')]
    public $hidup;

    #[Validate('nullable|numeric')]
    public $doctor_id;
    public $nurse_id;

    public $illness_history = [];
    public $allergy_history = [];
    public $main_complaints;
    public $specific_attention;
    public $other_history;

    public $patient_awareness = 'Compos Mentis';

    #[Validate('nullable|numeric', as: 'Tinggi')]
    public $height;

    #[Validate('nullable|numeric', as: 'Berat')]
    public $weight;

    #[Validate('nullable|numeric', as: 'Suhu Tubuh')]
    public $body_temperature = 36;

    #[Validate('nullable|numeric', as: 'Sistole')]
    public $sistole;

    #[Validate('nullable|numeric', as: 'Diastole')]
    public $diastole;

    #[Validate('nullable|numeric', as: 'Nadi')]
    public $pulse;

    #[Validate('nullable|numeric', as: 'Frekuensi Pernafasan')]
    public $respiratory_frequency = 20;

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
    public $edd;
    public $blood_type;
    public $random_blood_sugar;
    public $hemoglobin;
    public $hbsag = 'Negatif';
    public $hiv = 'Non Reaktif';
    public $syphilis = 'Non Reaktif';
    public $urine_reduction = 'Negatif';
    public $urine_protein = 'Negatif';
    public $ph;
    public $summary;
    public $other_lab;
    public $other_recipe;

    public $subjective_summary;
    public $objective_summary;
    public $assessment_summary;
    public $plan_summary;
    public $other_summary;

    public $all_illness_history;
    public $all_allergy_history;
    public $firstEntry;

    #[Validate('nullable|date', as: 'Periksa berikutnya')]
    public $next_control;
    public $plan_note;

    public $patient_id;
    public $bmi;
    public $bmi_status;
    public $showLab = false;
    #[Validate('nullable|date', as: 'Tanggal Pemeriksaan Lab')]
    public $date_lab;
    public $date;
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

    #[On('refresh-medical-record')]
    public function refresh()
    {
    }

    public function mount(Registration $registration)
    {
        $tmpData = TmpData::whereUserId(auth()->user()->getAuthIdentifier())->get();
        $this->date = Carbon::now()->format('Y-m-d');
        foreach ($tmpData as $t) {
            if ($t->field_type == 'file' && Storage::exists($t->value)) {
                Storage::delete($t->value);
            }
        }
        TmpData::whereUserId(auth()->user()->getAuthIdentifier())->delete();
        if ($registration->uuid) {
            $this->user_id = $registration->user_id;
            $this->registration = $registration;
            $this->firstEntry = FirstEntry::with('patient.user.vaccines', 'patient')->where('patient_id', $registration->user->patient->id)->orderBy('id', 'desc')->first();
            $this->user = $this->registration->user;
            $this->registration->load('user.patient.job');


            $this->lastMedicalRecord = MedicalRecord::with('allergyHistories', 'illnessHistories')->where('user_id', $this->user->id)->latest()->first();
            // $this->oldMedicalRecord = MedicalRecord::with('nurse', 'doctor', 'usgs', 'checks','actions','drugMedDevs','laborate')->where('user_id',  $this->user->id)->latest()->get();
            if ($this->lastMedicalRecord) {
                $this->illness_history = $this->lastMedicalRecord->illnessHistories->pluck('name');
                $this->allergy_history = $this->lastMedicalRecord->allergyHistories->pluck('name');
            }
            $this->blood_type = Patient::where('user_id', $this->user->id)->first()->blood_type;
            $this->hpht = $this->firstEntry && $this->firstEntry->hpht ? Carbon::parse($this->firstEntry->hpht)->format('d-m-Y') : NULL;
            $this->interpretation_childbirth = $this->firstEntry ? $this->firstEntry->edd : NULL;
            $this->main_complaints = $this->firstEntry ? $this->firstEntry->main_complaint : NULL;
            $this->specific_attention = $this->firstEntry ? $this->firstEntry->specific_attention : NULL;

            $this->timestamp = date('d F Y H:i:s');
            $this->patient_id = Patient::where('user_id', $this->user->id)->first()->id;
            $this->blood_type = $this->registration->user->patient->blood_type;
            $this->height = $this->firstEntry->height;

            if ($this->firstEntry) {
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

            if (Carbon::parse($this->firstEntry->time_stamp)->format('Y-m-d') == Carbon::now()->format('Y-m-d')) {
                $this->objective_summary = "TD:{$this->firstEntry->sistole}/{$this->firstEntry->diastole}; \nBB:{$this->firstEntry->weight} kg; \nTB:{$this->firstEntry->height} cm; \nS: {$this->firstEntry->body_temperature}; \nN: {$this->firstEntry->pulse};";
                $this->subjective_summary = $this->firstEntry->main_complaint;
                $this->body_temperature = $this->firstEntry->body_temperature;
                $this->sistole = $this->firstEntry->sistole;
                $this->diastole = $this->firstEntry->diastole;
                $this->weight = $this->firstEntry->weight;
                $this->pulse = $this->firstEntry->pulse;
                $this->patient_awareness = $this->firstEntry->patient_awareness;
                $this->respiratory_frequency = $this->firstEntry->respiratory_frequency;
                $this->random_blood_sugar = $this->firstEntry->random_blood_sugar;
                $this->hemoglobin = $this->firstEntry->hemoglobin;
                $this->hbsag = $this->firstEntry->hbsag;
                $this->hiv = $this->firstEntry->hiv;
                $this->syphilis = $this->firstEntry->syphilis;
                $this->urine_protein = $this->firstEntry->urine_protein;
                $this->urine_reduction = $this->firstEntry->urine_reduction;
                $this->date_lab = $this->firstEntry->date_lab ? Carbon::parse($this->firstEntry->date_lab)->format('d-m-Y') : NULL;
                $this->showLab = $this->firstEntry->date_lab ? true : false;
                $this->description = $this->firstEntry->description_physical;
                // $this->blood_type = $this->firstEntry->patient->blood_type;

                try {
                    $imt = number_format($this->firstEntry->weight / pow($this->firstEntry->height / 100, 2), '0', ',', '.');
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
                $this->bmi = $imt;
                $this->bmi_status = $imtStatus;
            }
        } else {
            $this->registration = null;
            $this->user = null;
            $this->firstEntry = null;
        }

        $this->all_illness_history = IllnessHistory::all();
        $this->all_allergy_history = AllergyHistory::all();
    }

    public function updated($property)
    {
        if ($property === 'user_id') {
            $this->lastMedicalRecord = MedicalRecord::with('allergyHistories', 'illnessHistories')->where('user_id', $this->user_id)->latest()->first();
            // dd($this->lastMedicalRecord);
            $this->user = User::with('patient', 'patient.job')->where('id', $this->user_id)->first();
            if ($this->lastMedicalRecord) {
                $this->illness_history = $this->lastMedicalRecord->illnessHistories->pluck('name');
                $this->allergy_history = $this->lastMedicalRecord->allergyHistories->pluck('name');
            }
            $this->timestamp = date('d F Y H:i:s');
            $this->patient_id = Patient::where('user_id', $this->user_id)->first()->id;
            // $this->oldMedicalRecord = MedicalRecord::with('nurse', 'doctor', 'usgs', 'checks','actions','drugMedDevs','laborate')->where('user_id',  $this->user_id)->latest()->get();
            // dd($this->oldMedicalRecord);
            $this->firstEntry = FirstEntry::with('patient.user.vaccines', 'patient')->where('patient_id', $this->patient_id)->orderBy('id', 'desc')->first();
            if (!$this->firstEntry) {
                $this->user = null;
                Toaster::error('Pasien ini belum memiliki Asesmen Awal. Mohon membuat Asesmen awal terlebih dahulu di menu Asesmen Awal');
                return;
            }

            $this->blood_type = Patient::where('user_id', $this->user_id)->first()->blood_type;
            $this->hpht = $this->firstEntry ? Carbon::parse($this->firstEntry->hpht)->format('d-m-Y') : NULL;
            $this->interpretation_childbirth = $this->firstEntry ? $this->firstEntry->edd : NULL;
            $this->main_complaints = $this->firstEntry ? $this->firstEntry->main_complaint : NULL;
            $this->specific_attention = $this->firstEntry ? $this->firstEntry->specific_attention : NULL;

            if ($this->firstEntry) {
                $intervalWeeks = floor(Carbon::now()->diffInWeeks(Carbon::parse($this->firstEntry->hpht)));
                $intervalDays = floor(Carbon::now()->diffInDays(Carbon::parse($this->firstEntry->hpht))) % 7;
                $this->age_childbirth = "{$intervalWeeks} minggu {$intervalDays} hari";
                $this->height = $this->firstEntry->height;
            } else {
                $this->age_childbirth = NULL;
            }

            if (Carbon::parse($this->firstEntry->time_stamp)->format('Y-m-d') == Carbon::now()->format('Y-m-d')) {
                $this->objective_summary = "TD:{$this->firstEntry->sistole}/{$this->firstEntry->diastole}; \nBB:{$this->firstEntry->weight} kg; \nTB:{$this->firstEntry->height} cm; \nS: {$this->firstEntry->body_temperature}; \nN: {$this->firstEntry->pulse};";
                $this->subjective_summary = $this->firstEntry->main_complaint;
                $this->body_temperature = $this->firstEntry->body_temperature;
                $this->sistole = $this->firstEntry->sistole;
                $this->diastole = $this->firstEntry->diastole;
                $this->weight = $this->firstEntry->weight;
                $this->pulse = $this->firstEntry->pulse;
                $this->patient_awareness = $this->firstEntry->patient_awareness;
                $this->respiratory_frequency = $this->firstEntry->respiratory_frequency;
                // $this->blood_type = $this->firstEntry->patient->blood_type;
                $this->random_blood_sugar = $this->firstEntry->random_blood_sugar;
                $this->hemoglobin = $this->firstEntry->hemoglobin;
                $this->hbsag = $this->firstEntry->hbsag;
                $this->hiv = $this->firstEntry->hiv;
                $this->syphilis = $this->firstEntry->syphilis;
                $this->urine_protein = $this->firstEntry->urine_protein;
                $this->urine_reduction = $this->firstEntry->urine_reduction;
                $this->date_lab = $this->firstEntry->date_lab ? Carbon::parse($this->firstEntry->date_lab)->format('d-m-Y') : NULL;

                $this->showLab = $this->firstEntry->date_lab ? true : false;
                $this->description = $this->firstEntry->description_physical;
                try {
                    $imt = number_format($this->firstEntry->weight / pow($this->firstEntry->height / 100, 2), '0', ',', '.');
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
                $this->bmi = $imt;
                $this->bmi_status = $imtStatus;
            }
            // dd($this->hpht,$this->interpretation_childbirth);
            // dd($this->lastMedicalRecord->illnessHistories);
        }
        if ($property === 'date') {
            $this->date = Carbon::parse($this->date)->setTimezone('Asia/Jakarta')->toDateString();
            $users = Registration::with([
                'user' => ['patient']
            ])->where('date', $this->date)->orderBy('queue_number', 'asc')->where('status', 'Administrasi')->get()->pluck('user');

            $this->dispatch('refresh-select2', users: $users);
        }
        // $this->dispatch('refresh-history-illness-drug');
        $this->dispatch('refresh-medical-record');
    }

    public function render()
    {
        $this->authorize('create', MedicalRecord::class);
        $datetime1 = $this->user ? new DateTime($this->user->patient->dob) : new DateTime();
        $datetime2 = new DateTime();
        $interval = $datetime1->diff($datetime2);

        $datetime1 = $this->user ? new DateTime($this->user->patient->husbands_birth_date) : new DateTime();
        $datetime2 = new DateTime();
        $age_husband = $datetime1->diff($datetime2);

        $registers = Registration::with([
            'user' => ['patient']
        ])->where('date', $this->date)->orderBy('queue_number', 'asc')->where('status', 'Administrasi')->get()->pluck('user');
        // $users =  User::with('patient')->whereHas('patient', function ($query) {
        //     $query->whereHas('firstEntry');
        // })->get();
        // $merged = collect();
        // for ($i = 0; $i < $users->count(); $i++) {
        //     if ($registers->contains(function ($value) use ($users, $i) {
        //         return $value->id == $users[$i]->id;
        //     })) {
        //         unset($users[$i]);
        //     }
        // }
        // $merged = $registers->merge($users);
        if (auth()->user()->role_id == 2) {
            // dd(MedicalRecord::with('allergyHistories', 'illnessHistories')->where('user_id', $this->user->id)->latest()->first());
            return view('livewire.medical-record.create-doctor', [
                'oldMedicalRecords' => MedicalRecord::with('nurse', 'registration', 'doctor', 'usgs', 'checks', 'actions', 'drugMedDevs', 'laborate')
                    ->whereHas('registration', function ($query) {
                        $query->where('status', 'Selesai');
                    })
                    ->where('user_id', $this->medicalRecord->user->id ?? 0)->latest()->get(),
                'age' => $interval,
                'users' => $registers,
                'obstetri' => Obstetri::where('patient_id', $this->patient_id)->orderBy('id', 'asc')->get(),
                'age_husband' => $age_husband,
                'firstEntry' => $this->firstEntry,

            ]);
        }
        return view('livewire.medical-record.create', [
            'age' => $interval,
            'age_husband' => $age_husband,
            'users' => $registers,
            'doctors' => User::with('healthWorker')->whereHas('healthWorker', function ($query) {
                $query->where('position', 'Dokter');
            })->get(),
            'obstetri' => Obstetri::where('patient_id', $this->patient_id)->orderBy('id', 'asc')->get(),
            'firstEntry' => $this->firstEntry,
            'medicalRecords' => MedicalRecord::with('nurse', 'firstEntry', 'registration', 'registration.branch', 'doctor', 'usgs', 'checks', 'actions', 'drugMedDevs', 'laborate')->where('user_id', empty($this->user_id) ? 0 : $this->user_id)->latest()->get()

        ]);
    }

    public function save()
    {
        $this->date_lab = $this->date_lab ? str_replace('/', '-', $this->date_lab) : NULL;
        $this->hpht = $this->hpht ? str_replace('/', '-', $this->hpht) : NULL;
        $this->interpretation_childbirth = $this->interpretation_childbirth ? str_replace('/', '-', $this->interpretation_childbirth) : NULL;
        $this->next_control = $this->next_control ? str_replace('/', '-', $this->next_control) : NULL;

        $this->validate();
        $this->authorize('create', MedicalRecord::class);

        // get first_entry
        if (!$this->registration && !$this->user) {
            Toaster::error('Gagal simpan. Pilih Pasien terlebih dahulu');
            return;
        }
        if (!$this->firstEntry) {
            Toaster::error('Pasien ini belum memiliki Asesmen Awal. Mohon membuat Asesmen awal terlebih dahulu di menu Asesmen Awal');
            return;
        }

        $checkMedicalRecord = MedicalRecord::where('user_id', $this->user->id)->where('date', Carbon::now()->toDateString())->first();
        if ($checkMedicalRecord) {
            Toaster::error('Gagal simpan. CPPT pasien ini telah dibuat');
            return;
        }
        if (auth()->user()->role->id == 2) {
            $this->doctor_id = auth()->user()->id;
            $this->nurse_id = NULL;
            // if(!$this->next_control){
            //     Toaster::error('Form Periksa Berikutnya wajib diisi');
            //     return;
            // }
        } else {
            $this->nurse_id = auth()->user()->id;
        }
        if (!$this->registration) {
            $check_registration = Registration::whereUserId($this->user->id)->where('date', date('Y-m-d'))->orderBy('id', 'desc')->first();
            if ($check_registration) {
                $this->registration = $check_registration;
            }
        }
        if ($this->showLab == true && !$this->date_lab) {
            Toaster::error('Tanggal Pemeriksaan wajib diisi jika anda mengisi data lab');
            return;
        }

        if ($this->showLab == false && $this->date_lab) {
            $this->date_lab = NULL;
        }

        try {
            DB::beginTransaction();
            $medicalRecord = new MedicalRecord();
            // $registration_id = Registration::first();
            if ($lastMedicalRecord = MedicalRecord::latest()->first()) {
                $medicalRecord->medical_record_number = date('d.m.y') . '-' . str_pad((int)explode('-', $lastMedicalRecord->medical_record_number)[1] + 1, 5, "0", STR_PAD_LEFT);
            } else {
                $medicalRecord->medical_record_number = date('d.m.y') . '-00001';
            }
            $medicalRecord->gravida = $this->gravida;
            $medicalRecord->para = $this->para;
            $medicalRecord->abbortion = $this->abbortion;
            $medicalRecord->hidup = $this->hidup;
            $medicalRecord->hpht = $this->hpht ? Carbon::parse($this->hpht) : null;
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
            $medicalRecord->ga = $this->ga;
            $medicalRecord->gs = $this->gs;
            $medicalRecord->crl = $this->crl;
            $medicalRecord->fl = $this->fl;
            $medicalRecord->ac = $this->ac;
            $medicalRecord->fhr = $this->fhr;
            $medicalRecord->efw = $this->efw;
            $medicalRecord->bpd = $this->bpd;
            $medicalRecord->edd = $this->interpretation_childbirth ? Carbon::parse($this->interpretation_childbirth)->toDateString() : NULL;
            $medicalRecord->blood_type = $this->blood_type;
            $medicalRecord->random_blood_sugar = $this->random_blood_sugar;
            $medicalRecord->hemoglobin = $this->hemoglobin;
            $medicalRecord->hbsag = $this->hbsag;
            $medicalRecord->hiv = $this->hiv;
            $medicalRecord->syphilis = $this->syphilis;
            $medicalRecord->urine_protein = $this->urine_protein;
            $medicalRecord->urine_reduction = $this->urine_reduction;
            $medicalRecord->ph = $this->ph;
            $medicalRecord->next_control = $this->next_control ? Carbon::parse($this->next_control) : null;
            $medicalRecord->subjective_summary = $this->subjective_summary;
            $medicalRecord->objective_summary = $this->objective_summary;
            $medicalRecord->assessment_summary = $this->assessment_summary;
            $medicalRecord->plan_summary = $this->plan_summary;
            $medicalRecord->other_summary = $this->other_summary;
            $medicalRecord->nurse_id = $this->nurse_id ?? NULL;
            $medicalRecord->doctor_id = $this->doctor_id ?? NULL;
            $medicalRecord->date = Carbon::now()->toDateString();
            $medicalRecord->user_id = $this->user->id;
            $medicalRecord->registration_id = $this->registration->id ?? NULL;
            $medicalRecord->summary = $this->summary;
            $medicalRecord->time_stamp = $this->timestamp;
            $medicalRecord->first_entry_id = $this->firstEntry->id ?? NULL;
            $medicalRecord->plan_note = $this->plan_note;
            $medicalRecord->other_lab = $this->other_lab;
            $medicalRecord->date_lab = $this->date_lab ? Carbon::parse($this->date_lab)->format('Y-m-d') : NULL;
            $medicalRecord->is_lab = $this->showLab;
            $medicalRecord->other_recipe = $this->other_recipe;

            $medicalRecord->save();

            if ($this->blood_type && $this->blood_type != '') {
                $this->user->patient->blood_type = $this->blood_type;
                $this->user->patient->save();
            }

            foreach ($this->illness_history as $ih) {
                if (!$illness_history = IllnessHistory::where('name', 'ilike', $ih)->first()) {
                    $illness_history = new IllnessHistory();
                    $illness_history->name = $ih;
                    $illness_history->save();
                }

                $medicalRecordHasIllnessHistory = new MedicalRecordHasIllnessHistory();
                $medicalRecordHasIllnessHistory->medical_record_id = $medicalRecord->id;
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
                $medicalRecordHasAllergyHistory->medical_record_id = $medicalRecord->id;
                $medicalRecordHasAllergyHistory->allergy_history_id = $allergy_history->id;
                $medicalRecordHasAllergyHistory->save();
            }

            $tmpData = TmpData::whereUserId(auth()->user()->id)->whereLocation('medical-record.create')->get()->groupBy('field_group');
            if (isset($tmpData['vaccine'])) {
                $vaccines = $tmpData['vaccine']->groupBy('temp_id');
                foreach ($vaccines as $v) {
                    $vaccine = new Vaccine();
                    $vaccine->name = $v->where('field', 'name')->first()->value;
                    $vaccine->brand = $v->where('field', 'brand')->first()->value;
                    $vaccine->date = Carbon::parse($v->where('field', 'date')->first()->value);
                    $vaccine->user_id = $this->user->id;
                    $vaccine->save();
                }
            }
            if (isset($tmpData['usg'])) {
                $usgs = $tmpData['usg']->groupBy('temp_id');
                foreach ($usgs as $u) {
                    $usg = new Usg();
                    $usg->usg_id = $u->where('field', 'usg_id')->first()->value;
                    $usg->file = $u->where('field', 'file')->first()->value;
                    $usg->date = Carbon::parse($u->where('field', 'date')->first()->value);
                    $usg->medical_record_id = $medicalRecord->id;
                    $usg->save();
                }
            }
            if (isset($tmpData['check'])) {
                $checks = $tmpData['check']->groupBy('temp_id');
                foreach ($checks as $u) {
                    $check = new Check();
                    $check->type = $u->where('field', 'type')->first()->value;
                    $check->file = $u->where('field', 'file')->first()->value;
                    $check->date = Carbon::parse($u->where('field', 'date')->first()->value);
                    $check->medical_record_id = $medicalRecord->id;
                    $check->save();
                }
            }
            if (isset($tmpData['laborate'])) {
                $laborate = $tmpData['laborate']->groupBy('temp_id');
                foreach ($laborate as $l) {
                    $laborate = Laborate::where('name', $l->where('field', 'lab_id')->first()->value)->first();
                    if (!$laborate) {
                        $newLaborate = new Laborate();
                        $newLaborate->name = $l->where('field', 'lab_id')->first()->value;
                        $newLaborate->save();

                        $medicalRecord->laborate()->attach($newLaborate->id);
                    } else {
                        $medicalRecord->laborate()->attach($laborate->id);
                    }
                }
            }

            if (isset($tmpData['action'])) {
                $actions = $tmpData['action']->groupBy('temp_id');
                foreach ($actions as $a) {
                    $action = new MedicalRecordHasAction();
                    $action->action_id = $a->where('field', 'action_id')->first()->value;
                    $action->medical_record_id = $medicalRecord->id;
                    $action->total = $a->where('field', 'total')->first()->value;
                    $action->save();
                }
            }

            if (isset($tmpData['drug'])) {
                $drugs = $tmpData['drug']->groupBy('temp_id');
                foreach ($drugs as $d) {
                    $drug = new MedicalRecordHasDrugMedDev();
                    $drug->medical_record_id = $medicalRecord->id;
                    $drug->drug_med_dev_id = $d->where('field', 'drug_med_dev_id')->first()->value;
                    $drug->total = $d->where('field', 'total')->first()->value;
                    $drug->rule = $d->where('field', 'rule')->first()->value;
                    $drug->how_to_use = $d->where('field', 'how_to_use')->first()->value;
                    $drug->save();
                }
            }

            if ($this->registration) {
                if (auth()->user()->role->id == 2) {
                    $this->registration->status = 'Kasir';

                    // $nextBooking = new Registration();
                    // $nextBooking->user_id = $this->registration->user_id;
                    // $nextBooking->branch_id = $this->registration->branch_id;
                    // $nextBooking->estimated_arrival = $this->registration->estimated_arrival;
                    // $nextBooking->date = Carbon::parse($this->next_control);
                    // $nextBooking->status = 'Administrasi';
                    // $nextBooking->finance_type = $this->registration->finance_type;
                    // $nextBooking->poli = $this->registration->poli;
                    // $nextBooking->save();
                } else {
                    $this->registration->status = 'Pemeriksaan';
                }
                $this->registration->save();
            }

            $log = new ActivityLog();
            $log->author = auth()->user()->name;
            $log->model = 'MedicalRecord';
            $log->model_id = $medicalRecord->id;
            $log->log = 'Telah membuat rekam medis';
            $log->save();
            DB::commit();
            TmpData::whereUserId(auth()->user()->id)->whereLocation('medical-record.create')->delete();
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
        if (!$this->date_lab_fe) {
            Toaster::error('Tanggal Pemeriksaan wajib diisi');
            return;
        }
        $this->date_lab_fe = $this->date_lab_fe ? str_replace('/', '-', $this->date_lab_fe) : NULL;

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
