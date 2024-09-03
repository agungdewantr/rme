<?php

namespace App\Livewire\FirstEntry;

use App\Models\ActivityLog;
use App\Models\FirstEntry;
use App\Models\MedicalRecord;
use App\Models\Obstetri;
use Carbon\Carbon;
use DateTime;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Toaster;

class Edit extends Component
{
    public ?FirstEntry $firstEntry;

    public $illness_history = [];
    public $allergy_history = [];
    public $timestamp;

    public $user_id;
    #[Validate('nullable|date', as: 'HPHT')]
    public $hpht;
    #[Validate('required', as: 'Keluhan Utama')]
    public $main_complaint;
    public $specific_attention;
    public $doctor;
    public $nurse;
    public $interpretation_childbirth;
    public $age_childbirth;
    // #[Validate('required', as: 'Kesadaran Pasien')]
    public $patient_awareness;

    #[Validate('required', as: 'Leher')]
    public $neck;

    #[Validate('required', as: 'kepala')]
    public $head;

    #[Validate('required', as: 'Dada')]
    public $chest;

    #[Validate('required', as: 'Mata')]
    public $eye;

    #[Validate('required', as: 'Abdomen')]
    public $abdomen;
    #[Validate('required', as: 'Jantung')]
    public $heart;
    #[Validate('required', as: 'Ekstremitas')]
    public $extremities;
    #[Validate('required', as: 'Paru')]
    public $lungs;
    #[Validate('required', as: 'Kulit')]
    public $skin;

    public $showLab = false;

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

    public $description_physical;

    public $blood_type;
    public $random_blood_sugar;
    public $hemoglobin;
    public $hbsag;
    public $hiv;
    public $syphilis;
    public $urine_reduction;
    public $urine_protein;
    #[Validate('nullable|date', as: 'Tanggal Pemeriksaan Lab')]
    public $date_lab;
    public $bmi;
    public $bmi_status;


    public function mount($uuid)
    {
        // $firstEntry = FirstEntry::with('patient.user.vaccines', 'patient')->where('uuid',$uuid)->first();
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
        $this->user_id = $firstEntry->patient->user_id;
        $this->firstEntry = $firstEntry;
        $this->hpht = $firstEntry->hpht != NULL ? Carbon::parse($firstEntry->hpht)->format('d-m-Y') : NULL;
        $this->interpretation_childbirth = $firstEntry->edd ? Carbon::parse($firstEntry->edd)->format('d-m-Y') : NULL;
        // $this->doctor = $firstEntry->doctor->name;
        $this->nurse = $firstEntry->nurse->name;
        $this->main_complaint = $firstEntry->main_complaint;
        $this->specific_attention = $firstEntry->specific_attention;
        $this->patient_awareness = $firstEntry->patient_awareness;
        $this->neck = $firstEntry->neck;
        $this->head = $firstEntry->head;
        $this->chest = $firstEntry->chest;
        $this->eye = $firstEntry->eye;
        $this->abdomen = $firstEntry->abdomen;
        $this->heart = $firstEntry->heart;
        $this->extremities = $firstEntry->extremities;
        $this->lungs = $firstEntry->lungs;
        $this->skin = $firstEntry->skin;
        $this->height = $firstEntry->height;
        $this->weight = $firstEntry->weight;
        $this->body_temperature = $firstEntry->body_temperature;
        $this->sistole = $firstEntry->sistole;
        $this->diastole = $firstEntry->diastole;
        $this->pulse = $firstEntry->pulse;
        $this->respiratory_frequency = $firstEntry->respiratory_frequency;
        $this->description_physical = $firstEntry->description_physical;
        $this->blood_type = $firstEntry->blood_type;
        $this->random_blood_sugar = $firstEntry->random_blood_sugar;
        $this->hemoglobin = $firstEntry->hemoglobin;
        $this->hbsag = $firstEntry->hbsag;
        $this->hiv = $firstEntry->hiv;
        $this->syphilis = $firstEntry->syphilis;
        $this->urine_reduction = $firstEntry->urine_reduction;
        $this->urine_protein = $firstEntry->urine_protein;
        $this->date_lab = $firstEntry->date_lab ? Carbon::parse($firstEntry->date_lab)->format('d-m-Y') : null;
        $this->showLab = $firstEntry->date_lab ? true : false;
        try {
            $imt = number_format($firstEntry->weight / pow($firstEntry->height / 100, 2), '0', ',', '.');
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


        $intervalWeeks = floor(Carbon::now()->diffInWeeks(Carbon::parse($firstEntry->hpht)));
        $intervalDays = floor(Carbon::now()->diffInDays(Carbon::parse($firstEntry->hpht))) % 7;

        $this->age_childbirth = "{$intervalWeeks} minggu {$intervalDays} hari";
    }

    #[On('refresh-first-entry-edit')]
    public function refresh()
    {
    }

    public function render()
    {
        $this->authorize('update', $this->firstEntry);

        $datetime1 = new DateTime($this->firstEntry->patient->dob);
        $datetime2 = new DateTime();
        $interval = $datetime1->diff($datetime2);


        $datetime1 = new DateTime($this->firstEntry->patient->husbands_birth_date);
        $datetime2 = new DateTime();
        $age_husband = $datetime1->diff($datetime2);
        return view('livewire.first-entry.edit', [
            'age' => $interval,
            'age_husband' => $age_husband,
            'logs' => ActivityLog::where('model_id', $this->firstEntry->id)->where('model', 'FirstEntry')->latest()->get(),
            'medicalRecords' => MedicalRecord::with('nurse', 'firstEntry', 'registration', 'doctor', 'usgs', 'checks', 'actions', 'drugMedDevs', 'laborate')->where('user_id', empty($this->user_id) ? 0 : $this->user_id)->get()

        ]);
    }

    public function addobstetri()
    {
        $newObstetri = new Obstetri();
        $newObstetri->patient_id = $this->firstEntry->patient_id;
        $newObstetri->gender = null;
        $newObstetri->weight = NULL;
        // $newObstetri->birth_date = NULL;
        $newObstetri->age = NULL;
        $newObstetri->save();
    }

    public function save()
    {
        $this->authorize('update', $this->firstEntry);

        $this->date_lab =  $this->date_lab ?  str_replace('/', '-', $this->date_lab) : NULL;
        $this->hpht = $this->hpht ? str_replace('/', '-', $this->hpht) : NULL;
        $this->interpretation_childbirth = $this->interpretation_childbirth ? str_replace('/','-', $this->interpretation_childbirth) : NULL;
        $this->validate();


        $firstEntry = FirstEntry::find($this->firstEntry->id);
        $obstetri = Obstetri::wherePatientId($firstEntry->patient_id)->get();
        if ($obstetri->contains('type_of_birth', '')) {
            Toaster::error('Satu atau lebih Obstetri tidak boleh kosong');
            return;
        }

        try {
            $firstEntry->hpht = !empty($this->hpht) ? Carbon::parse($this->hpht) : NULL;
            $firstEntry->edd = !empty($this->interpretation_childbirth) ? Carbon::parse($this->interpretation_childbirth) : NULL;
            $firstEntry->main_complaint = $this->main_complaint;
            $firstEntry->specific_attention = $this->specific_attention;
            $firstEntry->patient_awareness = $this->patient_awareness;
            $firstEntry->neck = $this->neck;
            $firstEntry->head = $this->head;
            $firstEntry->chest = $this->chest;
            $firstEntry->eye = $this->eye;
            $firstEntry->abdomen = $this->abdomen;
            $firstEntry->heart = $this->heart;
            $firstEntry->extremities = $this->extremities;
            $firstEntry->lungs = $this->lungs;
            $firstEntry->skin = $this->skin;
            $firstEntry->blood_type = $this->blood_type;
            $firstEntry->random_blood_sugar = $this->random_blood_sugar;
            $firstEntry->hemoglobin = $this->hemoglobin;
            $firstEntry->hbsag = $this->hbsag;
            $firstEntry->hiv = $this->hiv;
            $firstEntry->syphilis = $this->syphilis;
            $firstEntry->urine_protein = $this->urine_protein;
            $firstEntry->urine_reduction = $this->urine_reduction;
            $firstEntry->height = $this->height;
            $firstEntry->weight = $this->weight;
            $firstEntry->body_temperature = $this->body_temperature;
            $firstEntry->sistole = $this->sistole;
            $firstEntry->diastole = $this->diastole;
            $firstEntry->pulse = $this->pulse;
            $firstEntry->respiratory_frequency = $this->respiratory_frequency;
            $firstEntry->description_physical = $this->description_physical;
            $firstEntry->date_lab = $this->date_lab ? Carbon::parse($this->date_lab) : NULL;
            $firstEntryDirtyAttributes = $firstEntry->getDirty();
            $firstEntry->save();

            $this->firstEntry->patient->blood_type = $this->blood_type;
            $this->firstEntry->patient->save();


            if (!empty($firstEntryDirtyAttributes)) {
                $attributeChanged = collect();
                foreach ($firstEntryDirtyAttributes as $attribute => $newValue) {
                    $oldValue = $this->firstEntry->getOriginal($attribute); // Get the original value
                    // Log the change with attribute name, old value, and new value
                    $attributeChanged->push($attribute . ' dari ' . $oldValue . ' ke ' . $newValue);
                }
                $log = new ActivityLog();
                $log->author = auth()->user()->name;
                $log->model = 'FirstEntry';
                $log->model_id = $this->firstEntry->id;
                $log->log = 'Mengubah first entry pada isian ' . $attributeChanged->join(', ');
                $log->save();
            }
            Toaster::success('Asesmen Awal berhasil diubah');
            return $this->redirectRoute('dashboard', navigate: true);
        } catch (\Throwable $th) {
            dd($th);
            Toaster::error('Gagal simpan, silakan coba beberapa saat lagi');
        }
    }
}
