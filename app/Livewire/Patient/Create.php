<?php

namespace App\Livewire\Patient;

use App\Models\City;
use App\Models\EmergencyContact;
use App\Models\Insurance;
use App\Models\Job;
use App\Models\Patient;
use App\Models\User;
use App\Traits\UploadFile;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;
use Masmerise\Toaster\Toaster;
use Propaganistas\LaravelPhone\PhoneNumber;

class Create extends Component
{
    use WithFileUploads, UploadFile;

    public $insurances = [];
    public $photo;
    public $nik;
    public $name;
    // public $pob;
    public $dob;
    public $blood_type;
    public $gender = 0;
    public $phone_number;
    public $job_id;
    public $address;
    public $city;
    public $email;
    public $insurance;
    public $status_pernikahan;
    public $citizenship = 'WNI';
    public $husbands_name;
    public $husbands_nik;
    public $husbands_birth_date;
    public $husbands_job;
    public $husbands_address;
    public $husbands_citizenship = 'WNI';
    public $husbands_note;
    public $age_of_marriage;
    public $month_of_marriage;
    public $husbands_phone_number;
    public $emergency_contacts = [];

    public function rules()
    {
        return [
            'photo' => 'nullable|image|max:2048',
            'nik' => 'required|unique:patients|string|size:16',
            'name' => 'required',
            // 'pob' => 'required',
            'dob' => 'required|date',
            'blood_type' => ['required', Rule::in(['A-', 'A+', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-', 'Belum diidentifikasi'])],
            'gender' => 'required|boolean',
            'status_pernikahan' => ['required', Rule::in(['Belum Menikah', 'Menikah', 'Janda'])],
            'job_id' => 'required',
            'address' => 'required',
            'city' => 'required',
            'phone_number' => 'required|min:10|phone:ID',
            'citizenship' => ['required', Rule::in(['WNI', 'WNA'])],
            'email' => ['nullable', 'email:rfc,dns', Rule::unique('users')],
            'insurances' => ['nullable', 'array', Rule::requiredIf($this->insurance == 'Ya')],
            // 'husbands_name' => ['nullable',Rule::requiredIf($this->status_pernikahan == 'Menikah')],
            'husbands_nik' => 'nullable',
            'husbands_birth_date' => ['nullable', Rule::requiredIf($this->status_pernikahan == 'Menikah')],
            // 'husbands_job' => ['nullable', Rule::requiredIf($this->status_pernikahan == 'Menikah')],
            'husbands_address' => 'nullable',
            'husbands_citizenship' => 'nullable',
            'age_of_marriage' => 'nullable',
            'month_of_marriage' => 'nullable',
            'husbands_note' => 'nullable',
        ];
    }

    public function validationAttributes()
    {
        return [
            'photo' => 'Foto',
            'nik' => 'NIK',
            'name' => 'Nama Pasien',
            // 'pob' => 'Tempat Lahir',
            'dob' => 'Tanggal Lahir',
            'blood_type' => 'Golongan darah',
            'gender' => 'Jenis Kelamin',
            'job_id' => 'Pekerjaan',
            'address' => 'Alamat',
            'city' => 'Kota',
            'phone_number' => 'Handphone',
            'email' => 'Email',
            'status_pernikahan' => 'Status Pernikahan',
            'citizenship' => 'Kewarganegaraan',
            'husbands_name' => 'Nama Suami',
            'husbands_nik' => 'NIK Suami',
            'husbands_birth_date' => 'Tanggal Lahir Suami',
            'husbands_job' => 'Pekerjaan Suami',
            'husbands_address' => 'Alamat Suami',
            'husbands_citizenship' => 'Kewarganegaraan Suami',
            'age_of_marriage' => 'Lama Pernikahan (Tahun)',
            'month_of_marriage' => 'Lama Pernikahan (Bulan)',
            'husbands_note' => 'Keterangan Suami',
        ];
    }

    public function render()
    {
        $this->authorize('create', Patient::class);
        return view('livewire.patient.create', [
            'jobs' => Job::all(),
            'cities' => City::all(),
        ]);
    }

    #[On('patient-save')]
    public function save()
    {
        // if(!$this->husbands_birth_date && $this->status_pernikahan == 'Menikah'){
        //     Toaster::error('Tanggal Lahir Suami wajib diisi');
        //     return;
        // }
        // if (!$this->husbands_job && $this->status_pernikahan == 'Menikah') {
        //     Toaster::error('Pekerjaan Suami wajib diisi');
        //     return;
        // }
        if ($this->insurance == 'Ya' && $this->insurances == []) {
            Toaster::error('Apabila memiliki asuransi, maka wajib diisi minimal 1');
            return;
        }
        $emergency_contacts = collect($this->emergency_contacts);
        if ($emergency_contacts->contains('name', '')) {
            Toaster::error('Satu atau lebih nama kontak darurat kosong');
            return;
        }
        if ($emergency_contacts->contains('relationship', '')) {
            Toaster::error('Satu atau lebih hubungan kontak darurat kosong');
            return;
        }
        if ($emergency_contacts->contains('phone_number', '')) {
            Toaster::error('Satu atau lebih nomor telepon kontak darurat kosong');
            return;
        }
        if ($emergency_contacts->every(function ($contact) {
            return strlen($contact['phone_number']) < 10;
        })) {
            Toaster::error('Satu atau lebih nomor telepon kontak darurat tidak sesuai format. Minimal 10 Angka');
            return;
        }
        if ($emergency_contacts->contains('address', '')) {
            Toaster::error('Satu atau lebih alamat kontak darurat kosong');
            return;
        }
        if ($emergency_contacts->contains('job', '')) {
            Toaster::error('Satu atau lebih pekerjaan kontak darurat kosong');
            return;
        }
        // $this->validate();
        $validated = Validator::make(
            [
                'photo' => $this->photo,
                'nik' => $this->nik,
                'name' => $this->name,
                // 'pob' => $this->pob,
                'dob' => $this->dob,
                'blood_type' => $this->blood_type,
                'gender' => $this->gender,
                'status_pernikahan' => $this->status_pernikahan,
                'job_id' => $this->job_id,
                'citizenship' => $this->citizenship,
                'email' => $this->email,
                'insurances' => $this->insurances,
                'phone_number' => $this->phone_number,
                'address' => $this->address,
                'city' => $this->city,
                'husbands_name' => $this->husbands_name,
                'husbands_nik' => $this->husbands_nik,
                'husbands_birth_date' => $this->husbands_birth_date,
                'husbands_job' => $this->husbands_job,
                'husbands_address' => $this->husbands_address,
                'husbands_citizenship' => $this->husbands_citizenship,
                'age_of_marriage' => $this->age_of_marriage,
                'month_of_marriage' => $this->month_of_marriage,
                'husbands_note' => $this->husbands_note
            ],
            [
                'photo' => 'nullable|image|max:2048',
                'nik' => 'required|unique:patients|string|size:16',
                'name' => 'required',
                // 'pob' => 'required',
                'dob' => 'required|date',
                'blood_type' => ['required', Rule::in(['A-', 'A+', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-', 'Belum diidentifikasi'])],
                'gender' => 'required|boolean',
                'status_pernikahan' => ['required', Rule::in(['Belum Menikah', 'Menikah', 'Janda'])],
                'job_id' => 'required',
                'address' => 'required',
                'city' => 'required',
                'phone_number' => 'required|min:10|phone:ID',
                'citizenship' => ['required', Rule::in(['WNI', 'WNA'])],
                'email' => ['nullable', 'email:rfc,dns', Rule::unique('users')],
                'insurances' => ['nullable', 'array', Rule::requiredIf($this->insurance == 'Ya')],
                // 'husbands_name' => ['nullable',Rule::requiredIf($this->status_pernikahan == 'Menikah')],
                'husbands_nik' => 'nullable',
                'husbands_birth_date' => ['nullable', Rule::requiredIf($this->status_pernikahan == 'Menikah')],
                // 'husbands_job' => ['nullable', Rule::requiredIf($this->status_pernikahan == 'Menikah')],
                'husbands_address' => 'nullable',
                'husbands_citizenship' => 'nullable',
                'age_of_marriage' => 'nullable',
                'month_of_marriage' => 'nullable',
                'husbands_note' => 'nullable',
            ],
        );
        $this->validate();
        if ($validated->fails()) {
            $errors = $validated->errors()->all();
            foreach ($errors as $message) {
                Toaster::error($message);
            }
            return;
            // Toaster::error($msg);
            // $this->validate();

        }

        $this->authorize('create', Patient::class);
        $phone_number = new PhoneNumber($this->phone_number, 'ID');
        try {
            DB::beginTransaction();
            $user = new User();
            $user->name = $this->name;
            $user->email = $this->email == '' || $this->email == NULL ? NULL : $this->email;
            $user->password = bcrypt(substr($this->nik, 0, 3) . Carbon::parse($this->dob)->format('dm'));
            $user->role_id = 3;
            $user->save();

            $lastPatient = Patient::latest()->first();
            $patient = new Patient();
            if ($this->photo) {
                $patient->photo_profile = $this->upload('photo_profile', $this->photo);
            }
            if ($lastPatient == null) {
                $patient->patient_number = '0001' . '.' . Carbon::parse($this->dob)->format('dmy');
            } else {
                $patient->patient_number = str_pad((int)explode('.', $lastPatient->patient_number)[0] + 1, 4, "0", STR_PAD_LEFT) . '.' . Carbon::parse($this->dob)->format('dmy');
            }

            if (is_numeric($this->job_id)) {
                $check_job = Job::find($this->job_id);
                if (!$check_job) {
                    $check_job = new Job();
                    $check_job->name = ucwords(strtolower($this->job_id));
                    $check_job->save();
                }
            } else {
                $check_job = Job::where('name', 'ilike', $this->job_id)->first();
                if (!$check_job) {
                    $check_job = new Job();
                    $check_job->name = ucwords(strtolower($this->job_id));
                    $check_job->save();
                }
            }
            if ($this->husbands_job) {
                if (is_numeric($this->husbands_job)) {
                    $check_husbandjob = Job::find($this->husbands_job);
                    if (!$check_husbandjob) {
                        $check_husbandjob = new Job();
                        $check_husbandjob->name = ucwords(strtolower($this->husbands_job));
                        $check_husbandjob->save();
                    }
                } else {
                    $check_husbandjob = Job::where('name', 'ilike', $this->husbands_job)->first();
                    if (!$check_husbandjob) {
                        $check_husbandjob = new Job();
                        $check_husbandjob->name = ucwords(strtolower($this->husbands_job));
                        $check_husbandjob->save();
                    }
                }
            }
            if ($this->city) {
                $check_city = City::where('name', 'ilike', $this->city)->first();
                if (!$check_city) {
                    $new_city = new City();
                    $new_city->name = ucwords(strtolower($this->city));
                    $new_city->save();
                }
            }
            $job_id = $check_job->id;


            $patient->name = ucwords(strtolower($this->name));
            $patient->address = ucwords(strtolower($this->address));
            $patient->nik = $this->nik;
            // $patient->pob = $this->pob;
            $patient->dob = Carbon::parse($this->dob);
            $patient->blood_type = $this->blood_type;
            $patient->gender = $this->gender;
            $patient->job_id = $job_id;
            $patient->city = $this->city;
            $patient->phone_number = $phone_number->formatE164();
            $patient->user_id = $user->id;
            $patient->status_pernikahan = $this->status_pernikahan;
            $patient->citizenship = $this->citizenship;
            $patient->husbands_name = ucwords(strtolower($this->husbands_name));
            $patient->husbands_nik = $this->husbands_nik;
            $patient->husbands_birth_date = $this->husbands_birth_date ? Carbon::parse($this->husbands_birth_date) : NULL;
            $patient->husbands_job = $this->husbands_job;
            $patient->husbands_address = ucwords(strtolower($this->husbands_address));
            $patient->husbands_citizenship = $this->husbands_citizenship;
            $patient->age_of_marriage = $this->age_of_marriage;
            $patient->month_of_marriage = $this->month_of_marriage;
            $patient->husbands_phone_number = $this->husbands_phone_number;
            $patient->husbands_note = $this->husbands_note;
            $patient->save();

            if (is_array($this->insurances)) {
                foreach ($this->insurances as $i) {
                    $insurance = new Insurance();
                    $insurance->name = $i['name'];
                    $insurance->number = $i['number'];
                    $insurance->patient_id = $patient->id;
                    $insurance->save();
                }
            }
            foreach ($emergency_contacts as $ec) {
                $emergency_contact = new EmergencyContact();
                $emergency_contact->name = ucwords(strtolower($ec['name']));
                $emergency_contact->address = ucwords(strtolower($ec['address']));
                $emergency_contact->phone_number = $ec['phone_number'];
                $emergency_contact->relationship = $ec['relationship'];
                $emergency_contact->job = $ec['job'];
                $emergency_contact->patient_id = $patient->id;
                $emergency_contact->save();
            }
            DB::commit();
            Toaster::success('Pasien berhasil dibuat');
            return $this->redirectRoute('patient.index', navigate: true);
        } catch (\Throwable $th) {
            dd($th);
            DB::rollback();
            Toaster::error('Pasien gagal dibuat. Silakan coba beberapa saat lagi');
        }
    }

    #[On('generate-nik')]
    public function generate_nik()
    {
        $nik = mt_rand(1000000000000000, 9999999999999999);
        if (Patient::where('nik', $nik)->exists()) {
            $nik = mt_rand(1000000000000000, 9999999999999999);
        } else {
            $this->nik = (string)$nik;
        }
    }

    #[On('insert-insurance')]
    public function insertInsurance($name, $number)
    {
        $this->insurances[] = ['id' => rand(), 'name' => $name, 'number' => $number];
    }
}
