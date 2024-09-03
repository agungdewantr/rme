<?php

namespace App\Livewire\Patient;

use App\Models\City;
use App\Models\EmergencyContact;
use App\Models\Insurance;
use App\Models\Job;
use App\Models\MedicalRecord;
use App\Models\Patient;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;
use Livewire\Component;
use Propaganistas\LaravelPhone\PhoneNumber;
use Toaster;

class Edit extends Component
{
    public ?Patient $patient;
    public $insurances = [];
    public $nik;
    public $name;
    // public $pob;
    public $dob;
    public $blood_type;
    public $gender;
    public $phone_number;
    public $job_id;
    public $address;
    public $city;
    public $email;
    public $insurance;
    public $status_pernikahan;
    public $citizenship;
    public $husbands_data;
    public $husbands_name;
    public $husbands_nik;
    public $husbands_birth_date;
    public $husbands_phone_number;
    public $husbands_job;
    public $husbands_address;
    public $husbands_citizenship;
    public $age_of_marriage;
    public $month_of_marriage;
    public $husbands_note;
    public $emergencyContacts = [];

    public function mount(Patient $patient)
    {
        $patient->load('insurances', 'user', 'emergencyContacts');
        $this->emergencyContacts = $patient->emergencyContacts->toArray();
        $this->patient = $patient;
        $this->insurances = $patient->insurances;
        $this->nik = $patient->nik;
        $this->name = ucwords(strtolower($patient->name));
        // $this->pob = $patient->pob;
        $this->dob = $patient->dob;
        $this->blood_type = $patient->blood_type;
        $this->gender = $patient->gender ? 'true' : 'false';
        $this->phone_number = substr($patient->phone_number, 3);
        $this->job_id = $patient->job_id;
        $this->address = $patient->address;
        $this->city = $patient->city;
        $this->email = $patient->user->email;
        $this->insurance = count($patient->insurances) > 0 ? true : false;
        $this->status_pernikahan = $patient->status_pernikahan;
        $this->citizenship = $patient->citizenship;
        $this->husbands_data = $patient->status_pernikahan == 'Menikah';
        $this->husbands_name = ucwords(strtolower($patient->husbands_name));
        $this->husbands_phone_number = $patient->husbands_phone_number;
        $this->husbands_nik = $patient->husbands_nik;
        $this->husbands_birth_date = $patient->husbands_birth_date;
        $this->husbands_citizenship = $patient->husbands_citizenship;
        $this->husbands_address = $patient->husbands_address;
        $this->husbands_job = $patient->husbands_job;
        $this->age_of_marriage = $patient->age_of_marriage;
        $this->husbands_note = $patient->husbands_note;
        $this->month_of_marriage = $patient->month_of_marriage;
    }

    public function rules()
    {
        return [
            'nik' => ['required', Rule::unique('patients')->ignore($this->patient->id), 'string', 'size:16'],
            'name' => 'required',
            // 'pob' => 'required',
            'dob' => 'required|date',
            'blood_type' => ['required', Rule::in(['A-', 'A+', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-', 'Belum diidentifikasi'])],
            'gender' => ['required', Rule::in(['true', 'false'])],
            'status_pernikahan' => ['required', Rule::in(['Belum Menikah', 'Menikah', 'Janda'])],
            'job_id' => 'required',
            'address' => 'required',
            'city' => 'required',
            'phone_number' => 'required|min:10|phone:ID',
            'email' => ['nullable', 'email:rfc,dns', Rule::unique('users')->ignore($this->patient->user)],
            'insurances' => ['nullable', 'array', Rule::requiredIf($this->insurance == 'Ya')],
            'citizenship' => ['required', Rule::in(['WNI', 'WNA'])],
            // 'husbands_name' => ['nullable',Rule::requiredIf($this->status_pernikahan == 'Menikah')],
            'husbands_nik' => 'nullable',
            'husbands_birth_date' => 'nullable',
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
        $this->authorize('update', $this->patient);
        return view('livewire.patient.edit', [
            'jobs' => Job::all(),
            'patient' => $this->patient,
            'cities' => City::all(),
            'medicalRecords' => MedicalRecord::with('doctor', 'nurse', 'usgs', 'registration', 'registration.branch', 'drugMedDevs', 'actions', 'laborate', 'firstEntry')->where('user_id', empty($this->patient->user_id) ? 0 : $this->patient->user_id)->latest()->get(),

        ]);
    }

    #[On('patient-update')]
    public function save()
    {
        $check_insurances = Insurance::wherePatientId($this->patient->id)->count();
        if ($this->insurance == true && $check_insurances < 1) {
            Toaster::error('Apabila memiliki asuransi, maka wajib diisi minimal 1');
            return;
        }
        // if(!$this->husbands_birth_date && $this->status_pernikahan == 'Menikah'){
        //     Toaster::error('Tanggal Lahir Suami wajib diisi');
        //     return;
        // }
        // if (!$this->husbands_job && $this->status_pernikahan == 'Menikah') {
        //     Toaster::error('Pekerjaan Suami wajib diisi');
        //     return;
        // }
        $emergencyContacts = collect($this->emergencyContacts);
        if ($emergencyContacts->contains('name', '')) {
            Toaster::error('Satu atau lebih nama kontak darurat kosong');
            return;
        }
        if ($emergencyContacts->contains('relationship', '')) {
            Toaster::error('Satu atau lebih hubungan kontak darurat kosong');
            return;
        }
        if ($emergencyContacts->contains('phone_number', '')) {
            Toaster::error('Satu atau lebih nomor telepon kontak darurat kosong');
            return;
        }
        if ($emergencyContacts->every(function ($contact) {
            return strlen($contact['phone_number']) < 10;
        })) {
            Toaster::error('Satu atau lebih nomor telepon kontak darurat tidak sesuai format. Minimal 10 Angka');
            return;
        }
        if ($emergencyContacts->contains('address', '')) {
            Toaster::error('Satu atau lebih alamat kontak darurat kosong');
            return;
        }
        if ($emergencyContacts->contains('job', '')) {
            Toaster::error('Satu atau lebih pekerjaan kontak darurat kosong');
            return;
        }

        $this->validate();
        $this->authorize('update', $this->patient);

        $phone_number = new PhoneNumber($this->phone_number, 'ID');
        try {
            DB::beginTransaction();
            $user = $this->patient->user;
            $user->name = $this->name;
            $user->email = $this->email == '' || $this->email == NULL ? NULL : $this->email;
            $user->save();

            if (is_numeric($this->job_id)) {
                $check_job = Job::find($this->job_id);
                if (!$check_job) {
                    $check_job = new Job();
                    $check_job->name = $this->job_id;
                    $check_job->save();
                }
            } else {
                $check_job = new Job();
                $check_job->name = $this->job_id;
                $check_job->save();
            }
            $job_id = $check_job->id;
            $this->patient->name = $this->name;
            $this->patient->address = $this->address;
            $this->patient->nik = $this->nik;
            // $this->patient->pob = $this->pob;
            $this->patient->dob = Carbon::parse($this->dob);
            $this->patient->blood_type = $this->blood_type;
            $this->patient->gender = $this->gender;
            $this->patient->job_id = $job_id;
            $this->patient->city = $this->city;
            $this->patient->phone_number = $phone_number->formatE164();
            $this->patient->status_pernikahan = $this->status_pernikahan;
            $this->patient->citizenship = $this->citizenship;
            $this->patient->husbands_name = $this->husbands_name;
            $this->patient->husbands_nik = $this->husbands_nik;
            $this->patient->husbands_birth_date = $this->husbands_birth_date ? Carbon::parse($this->husbands_birth_date) : NULL;
            $this->patient->husbands_job = $this->husbands_job;
            $this->patient->husbands_address = $this->husbands_address;
            $this->patient->husbands_citizenship = $this->husbands_citizenship;
            $this->patient->age_of_marriage = $this->age_of_marriage;
            $this->patient->month_of_marriage = $this->month_of_marriage;
            $this->patient->husbands_note = $this->husbands_note;
            $this->patient->save();

            // Ambil semua data EmergencyContact dari database
            $existing_contacts = EmergencyContact::where('patient_id', $this->patient->id)->pluck('id')->toArray();

            // Ambil id dari data inputan
            $input_ids = array_filter(array_column($this->emergencyContacts, 'id'));

            // Cari id yang ada di database tetapi tidak ada di inputan
            $ids_to_delete = array_diff($existing_contacts, $input_ids);

            // Hapus data yang id-nya ada di $ids_to_delete
            EmergencyContact::whereIn('id', $ids_to_delete)->delete();

            foreach ($emergencyContacts as $ec) {
                if ($ec['patient_id'] != '') {
                    $emergency_contact = EmergencyContact::where('id', $ec['id'])->where('patient_id', $ec['patient_id'])->first();
                    if ($emergency_contact) {
                        $emergency_contact->name = ucwords(strtolower($ec['name']));
                        $emergency_contact->address = ucwords(strtolower($ec['address']));
                        $emergency_contact->phone_number = $ec['phone_number'];
                        $emergency_contact->relationship = $ec['relationship'];
                        $emergency_contact->job = $ec['job'];
                        $emergency_contact->save();
                    }
                } else {
                    $emergency_contact = new EmergencyContact();
                    $emergency_contact->name = ucwords(strtolower($ec['name']));
                    $emergency_contact->address = ucwords(strtolower($ec['address']));
                    $emergency_contact->phone_number = $ec['phone_number'];
                    $emergency_contact->relationship = $ec['relationship'];
                    $emergency_contact->job = $ec['job'];
                    $emergency_contact->patient_id = $this->patient->id;
                    $emergency_contact->save();
                }

            }
            DB::commit();
            Toaster::success('Data Pasien berhasil diubah');
            return $this->redirectRoute('patient.index', navigate: true);
        } catch (\Throwable $th) {
            DB::rollback();
            Toaster::error('Data Pasien gagal diubah. Sialakan coba beberapa saat lagi ' . $th->getMessage());
        }
    }

    #[On('refresh-patient-edit')]
    public function refresh()
    {
    }

    public function addEmergencyContact()
    {
        $emergency_contact = new EmergencyContact();
        $emergency_contact->name = '';
        $emergency_contact->address = '';
        $emergency_contact->phone_number = '';
        $emergency_contact->relationship = '';
        $emergency_contact->patient_id = $this->patient->id;
        $emergency_contact->save();
    }
}
