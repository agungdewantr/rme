<?php

namespace App\Livewire\FirstEntry;

use App\Models\ActivityLog;
use App\Models\FamilyIllnessHistory;
use App\Models\FirstEntry;
use App\Models\FirstEntryHasAllergiesHistory;
use App\Models\FirstEntryHasIllnessHistory;
use App\Models\MedicalRecord;
use App\Models\Obstetri;
use App\Models\PatientHasAllergyHistories;
use App\Models\PatientHasIllnessHistories;
use App\Models\Registration;
use App\Models\TmpData;
use App\Models\User;
use App\Models\Vaccine;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

class Create extends Component
{
    public $user;
    public  $registration;
    public $user_id;
    public $timestamp;

    #[Validate('nullable|date', as: 'HPHT')]
    public $hpht;
    #[Validate('required', as: 'Keluhan Utama')]
    public $main_complaint;
    public $specific_attention;
    // #[Validate('required', as: 'Nama Dokter')]
    // public $doctor_id;

    #[Validate('required', as: 'Kesadaran Pasien')]
    public $patient_awareness = 'Compos Mentis';

    #[Validate('required', as: 'Leher')]
    public $neck = 'Normal';

    #[Validate('required', as: 'kepala')]
    public $head = 'Normal';

    #[Validate('required', as: 'Dada')]
    public $chest = 'Normal';

    #[Validate('required', as: 'Mata')]
    public $eye = 'Normal';

    #[Validate('required', as: 'Abdomen')]
    public $abdomen = 'Normal';
    #[Validate('required', as: 'Jantung')]
    public $heart = 'Normal';
    #[Validate('required', as: 'Ekstremitas')]
    public $extremities = 'Normal';
    #[Validate('required', as: 'Paru')]
    public $lungs = 'Normal';
    #[Validate('required', as: 'Kulit')]
    public $skin = 'Normal';

    public $interpretation_childbirth;
    public $obstetri_array = [];
    public $count_obstetri;
    public $showLab = false;

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

    public $description_physical;

    public $blood_type;
    public $random_blood_sugar;
    public $hemoglobin;
    public $hbsag = 'Negatif';
    public $hiv= 'Non Reaktif';
    public $syphilis = 'Non Reaktif';
    public $urine_reduction= 'Negatif';
    public $urine_protein = 'Negatif';
    #[Validate('nullable|date', as: 'Tanggal Pemeriksaan Lab')]
    public $date_lab;
    public $date;




    // public function render()
    // {
    //     return view('livewire.first-entry.create');
    // }

    public function mount(Registration $registration)
    {
        TmpData::whereUserId(auth()->user()->getAuthIdentifier())->delete();
        $timstamp = null;
        $this->date = Carbon::now()->format('Y-m-d');
        if ($registration->uuid) {
            $this->registration = $registration;
            $registration->load('user.patient.job');
            $this->user = $registration->user;
            $this->timestamp = date('d F Y H:i:s');
            $this->blood_type = $registration->user->patient->blood_type;
            $this->user_id = $this->user->id;
        } else {
            $this->registration = null;
            $this->user = null;
        }
    }

    public function updated($property)
    {
        if ($property == 'user_id') {
            $this->user =  User::findOrFail($this->user_id);
            $this->blood_type = $this->user->patient->blood_type;
            $this->timestamp = date('d F Y H:i:s');
            $this->count_obstetri = Obstetri::where('patient_id', $this->user->patient->id)->count();
        }
        if($property === 'date'){
            $this->date = Carbon::parse($this->date)->setTimezone('Asia/Jakarta')->toDateString();
            $users = Registration::with([
                'user' => ['patient']
            ])->where('date', $this->date)->orderBy('queue_number', 'asc')->where('status', 'Administrasi')->get()->pluck('user');
            $this->dispatch('refresh-select2', users: $users);

        }
    }

    public function render()
    {
        $this->authorize('create', FirstEntry::class);

        $datetime1 = $this->user ? new DateTime($this->user->patient->dob) : new DateTime();
        $datetime2 = new DateTime();
        $interval = $datetime1->diff($datetime2);

        $datetime1 = $this->user ? new DateTime($this->user->patient->husbands_birth_date) : new DateTime();
        $datetime2 = new DateTime();
        $age_husband = $datetime1->diff($datetime2);

        $registers = Registration::with([
            'user' => ['patient']
        ])->where('date', $this->date)->orderBy('queue_number', 'asc')->where('status', 'Administrasi')->get()->pluck('user');
        $users =  User::with('patient')->has('patient')->get();
        // $merged = collect();
        // for ($i = 0; $i < $users->count(); $i++) {
        //     if ($registers->contains(function ($value) use ($users, $i) {
        //         return $value->id == $users[$i]->id;
        //     })) {
        //         unset($users[$i]);
        //     }
        // }
        // $merged = $registers->merge($users);
        return view('livewire.first-entry.create', [
            'users' => $registers,
            'age' => $interval,
            'age_husband' => $age_husband,
            'doctors' => User::with('healthWorker')->whereHas('healthWorker', function ($query) {
                $query->where('position', 'Dokter');
            })->get(),
            'obstetri' => Obstetri::where('patient_id', $this->user->patient->id ?? NULL)->orderBy('id')->get(),
            'medicalRecords' => MedicalRecord::with('nurse','firstEntry','registration', 'doctor', 'usgs', 'checks','actions','drugMedDevs','laborate')->where('user_id', empty($this->user_id) ? 0 : $this->user_id)->get()
        ]);
    }

    public function save()
    {
        $this->date_lab =  $this->date_lab ?  str_replace('/', '-', $this->date_lab) : NULL;
        $this->hpht = $this->hpht ? str_replace('/', '-', $this->hpht) : NULL;
        $this->interpretation_childbirth = $this->interpretation_childbirth ? str_replace('/','-', $this->interpretation_childbirth) : NULL;

        $checkFirstEntry = FirstEntry::where('patient_id', $this->user->patient->id)->whereDate('time_stamp', Carbon::parse($this->timestamp)->format('Y-m-d'))->first();
        if ($checkFirstEntry) {
            Toaster::error('Gagal simpan. Asesmen awal sudah dilakukan');
            return;
        }
        $this->authorize('create', FirstEntry::class);

        if ($this->showLab && !$this->date_lab) {
            Toaster::error('Gagal simpan. Tanggal Pemeriksaan Lab wajib diisi');
            return;
        }
        $this->validate();
        if (!$this->registration && !$this->user) {
            Toaster::error('Gagal simpan. Pilih Pasien terlebih dahulu');
            return;
        }
        // if (!$this->doctor_id) {
        //     Toaster::error('Gagal simpan. Pilih Dokter terlebih dahulu');
        //     return;
        // }
        try {
            DB::beginTransaction();
            $tmpData = TmpData::whereUserId(auth()->user()->id)->whereLocation('first-entry.create')->get()->groupBy('field_group');
            $genderError = 0;
            $weightError = 0;
            $typeOfBirthError = 0;
            $dateOfBirthError = 0;
            if (isset($tmpData['obstetri'])) {
                $obstetrisValidation = $tmpData['obstetri']->groupBy('temp_id');
                foreach ($obstetrisValidation as $o) {
                    if ($o->where('field', 'gender')->first()->value != null) {
                        if ($o->where('field', 'gender')->first()->value != 3) {
                            if (!$o->where('field', 'weight')->first()->value) {
                                $weightError++;
                            }
                            if (!$o->where('field', 'type_of_birth')->first()->value) {
                                $typeOfBirthError++;
                            }
                            // if (!$o->where('field', 'birth_date')->first()->value) {
                            //     $dateOfBirthError++;
                            // }
                        }
                    } else {
                        $genderError++;
                    }
                }
            }
            if ($genderError > 0 || $weightError > 0 || $typeOfBirthError > 0 || $dateOfBirthError > 0) {
                Toaster::error('Gagal simpan. Silahkan lengkapi data obstetri terlebih dahulu');
                return;
            }
            $first_entry = new FirstEntry();
            $first_entry->time_stamp = Carbon::parse($this->timestamp)->format('Y-m-d H:i:s');
            // $first_entry->doctor_id = $this->doctor_id ?? NULL;
            $first_entry->nurse_id = auth()->user()->id;
            $first_entry->hpht = $this->hpht ? Carbon::parse($this->hpht) : NULL;
            $first_entry->edd = $this->interpretation_childbirth ? Carbon::parse($this->interpretation_childbirth)->format('Y-m-d') : NULL;
            $first_entry->main_complaint = $this->main_complaint;
            $first_entry->specific_attention = $this->specific_attention;
            $first_entry->patient_id = $this->user->patient->id;
            $first_entry->registration_id = $this->registration->id ?? NULL;
            $first_entry->patient_awareness = $this->patient_awareness;
            $first_entry->neck = $this->neck;
            $first_entry->head = $this->head;
            $first_entry->chest = $this->chest;
            $first_entry->eye = $this->eye;
            $first_entry->abdomen = $this->abdomen;
            $first_entry->heart = $this->heart;
            $first_entry->extremities = $this->extremities;
            $first_entry->lungs = $this->lungs;
            $first_entry->skin = $this->skin;
            $first_entry->blood_type = $this->blood_type;
            $first_entry->random_blood_sugar = $this->random_blood_sugar;
            $first_entry->hemoglobin = $this->hemoglobin;
            $first_entry->hbsag = $this->hbsag;
            $first_entry->hiv = $this->hiv;
            $first_entry->syphilis = $this->syphilis;
            $first_entry->urine_protein = $this->urine_protein;
            $first_entry->urine_reduction = $this->urine_reduction;
            $first_entry->height = $this->height;
            $first_entry->weight = $this->weight;
            $first_entry->body_temperature = $this->body_temperature;
            $first_entry->sistole = $this->sistole;
            $first_entry->diastole = $this->diastole;
            $first_entry->pulse = $this->pulse;
            $first_entry->respiratory_frequency = $this->respiratory_frequency;
            $first_entry->description_physical = $this->description_physical;
            $first_entry->date_lab = $this->date_lab ? Carbon::parse($this->date_lab)->format('Y-m-d') : NULL;
            $first_entry->save();

            $this->user->patient->blood_type = $this->blood_type;
            $this->user->patient->save();

            // if (isset($tmpData['obstetri'])) {
            //     $obstetris = $tmpData['obstetri']->groupBy('temp_id');
            //     foreach ($obstetris as $o) {
            //         $obstetri = new Obstetri();
            //         $obstetri->patient_id = $this->user->patient->id;
            //         $obstetri->gender = $o->where('field', 'gender')->first()->value;
            //         $obstetri->weight = $o->where('field', 'weight')->first()->value;
            //         $obstetri->type_of_birth = $o->where('field', 'type_of_birth')->first()->value;
            //         $obstetri->age = $o->where('field', 'age')->first()->value;
            //         // $obstetri->birth_date =  Carbon::parse($o->where('field', 'birth_date')->first()->value)->format('Y-m-d');
            //         $obstetri->clinical_information = $o->where('field', 'clinical_information')->first()->value;
            //         $obstetri->save();
            //     }
            // }
            foreach ($this->obstetri_array as $o) {
                $obstetri = new Obstetri();
                $obstetri->patient_id = $this->user->patient->id;
                $obstetri->gender = $o['gender'] != '' ? $o['gender'] : NULL;
                $obstetri->weight = $o['weight'] != '' ? $o['weight'] : NULL;
                $obstetri->type_of_birth = $o['type_of_birth'];
                $obstetri->age = $o['age'] != '' ? $o['age'] : NULL;
                // $obstetri->birth_date =  Carbon::parse($o['birth_date']);
                $obstetri->clinical_information = $o['clinical_information'];
                $obstetri->save();
            }

            $tmpData_vaccine = TmpData::whereUserId(auth()->user()->id)->whereLocation('medical-record.create')->get()->groupBy('field_group');
            if (isset($tmpData_vaccine['vaccine'])) {
                $vaccines = $tmpData_vaccine['vaccine']->groupBy('temp_id');
                foreach ($vaccines as $v) {
                    $vaccine = new Vaccine();
                    $vaccine->name = $v->where('field', 'name')->first()->value;
                    $vaccine->brand = $v->where('field', 'brand')->first()->value;
                    $vaccine->date = Carbon::parse($v->where('field', 'date')->first()->value);
                    $vaccine->user_id = $this->user->id;
                    $vaccine->save();
                }
            }

            if (isset($tmpData['allergy'])) {
                $allergies = $tmpData['allergy']->groupBy('temp_id');
                foreach ($allergies as $a) {
                    $patientHasAllergy = new PatientHasAllergyHistories();
                    $patientHasAllergy->patient_id = $this->user->patient->id;
                    $patientHasAllergy->allergy_history_id = $a->where('field', 'allergy_history_id')->first()->value;
                    $patientHasAllergy->indication =  $a->where('field', 'indication')->first()->value;
                    $patientHasAllergy->save();
                }
            }
            if (isset($tmpData['illness'])) {
                $illnesses = $tmpData['illness']->groupBy('temp_id');
                foreach ($illnesses as $i) {
                    $patientHasIllness = new PatientHasIllnessHistories();
                    $patientHasIllness->patient_id = $this->user->patient->id;
                    $patientHasIllness->illness_history_id = $i->where('field', 'illness_history_id')->first()->value;
                    $patientHasIllness->therapy =  $i->where('field', 'therapy')->first()->value;
                    $patientHasIllness->save();
                }
            }

            if (isset($tmpData['familyillness'])) {
                $familyIllnesses = $tmpData['familyillness']->groupBy('temp_id');
                foreach ($familyIllnesses as $f) {
                    $familyIllness = new FamilyIllnessHistory();
                    $familyIllness->name = $f->where('field', 'name')->first()->value;
                    $familyIllness->relationship = $f->where('field', 'relationship')->first()->value;
                    $familyIllness->disease_name = $f->where('field', 'disease_name')->first()->value;
                    $familyIllness->patient_id = $this->user->patient->id;
                    $familyIllness->save();
                }
            }

            $log = new ActivityLog();
            $log->author = auth()->user()->name;
            $log->model = 'FirstEntry';
            $log->model_id = $first_entry->id;
            $log->log = 'Telah membuat asesmen awal';
            $log->save();

            TmpData::whereUserId(auth()->user()->id)->whereLocation('first-entry.create')->delete();
            DB::commit();
            Toaster::success('Asesmen Awal berhasil disimpan');
            return $this->redirectRoute('dashboard', navigate: true);
        } catch (\Throwable $th) {
            DB::rollback();
            dd($th);
            Toaster::error('Gagal simpan, silakan coba beberapa saat lagi');
        }
    }

    public function delete_obstetri($id)
    {
        $obstetri = Obstetri::whereId($id)->first();
        $obstetri->delete();
        Toaster::success('Data obstetri berhasil di hapus');
    }
}
