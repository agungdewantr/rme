<?php

namespace App\Livewire;

use App\Models\Branch;
use App\Models\City;
use App\Models\Job;
use App\Models\OperationalHour;
use App\Models\Patient;
use App\Models\Poli;
use App\Models\Promo;
use App\Models\Registration;
use App\Models\User;
use Carbon\Carbon;
use DateInterval;
use DatePeriod;
use DateTime;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Propaganistas\LaravelPhone\PhoneNumber;

class Appointment extends Component
{
    use LivewireAlert;

    public $patient;
    public $poli;
    public $polis = [];
    public $appointment_date;
    public $estimated_arrival;
    public $estimated_arrivals = [];
    public $estimated_hour;
    public $estimated_hours = [];
    public $name;
    public $nik;
    public $phone_number;
    public $payment_method;
    public $status_pernikahan;

    public $dob;
    public $branch_id;
    public $blood_type;
    public $gender = 0;
    public $job_id;
    public $address;
    public $city;
    public $type_input = 'pasien_baru';
    public $name_exist;
    public $nik_exist;
    public $phone_number_exist;
    public $patient_exist;
    public $status_pernikahan_exist;
    public $dob_exist;
    public $blood_type_exist;
    public $gender_exist;
    public $job_id_exist;
    public $address_exist;
    public $city_exist;
    public $day;
    public $checkup;
    public $disabledDaysIndexes;
    public $checkups = [];

    public function rules()
    {
        return [
            'nik' => ['nullable', 'unique:patients', 'string', 'size:16', Rule::requiredIf($this->type_input == 'pasien_baru')],
            'name' => ['nullable', 'string', Rule::requiredIf($this->type_input == 'pasien_baru')],
            'dob' => ['nullable', 'date', Rule::requiredIf($this->type_input == 'pasien_baru')],
            'blood_type' => ['nullable', Rule::in(['A-', 'A+', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-', 'Belum diidentifikasi']), Rule::requiredIf($this->type_input == 'pasien_baru')],
            'gender' => ['nullable', 'string', Rule::requiredIf($this->type_input == 'pasien_baru')],
            'status_pernikahan' => ['nullable', Rule::in(['Belum Menikah', 'Menikah', 'Janda']), Rule::requiredIf($this->type_input == 'pasien_baru')],
            'job_id' => ['nullable', Rule::requiredIf($this->type_input == 'pasien_baru')],
            'address' => ['nullable', Rule::requiredIf($this->type_input == 'pasien_baru')],
            'city' => ['nullable', Rule::requiredIf($this->type_input == 'pasien_baru')],
            'phone_number' => ['nullable', 'min:10', 'phone:ID', Rule::requiredIf($this->type_input == 'pasien_baru')],
            'appointment_date' => 'required|date',
            'branch_id' => 'required',
            'poli' => 'required',
            'checkup' => 'required',
            'estimated_arrival' => 'required',
            'estimated_hour' => 'required',
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
            'appointment_date' => 'Tanggal Appointment',
            'branch_id' => 'Lokasi Klinik',
            'poli' => 'Poli',
            'estimated_arrival' => 'Estimasi Kedatangan',
            'estimated_hour' => 'Estimasi Kedatangan',
            'checkup' => 'Tujuan Pemeriksaan',
        ];
    }


    public function mount()
    {
        $this->disabledDaysIndexes = json_encode([]);
    }

    #[Layout("components.layouts.appointment")]
    public function render()
    {
        return view('livewire.appointment', [
                'jobs' => Job::all(),
                'cities' => City::all(),
                'branches' => Branch::where('is_active', true)->get(),
                'promos' => Promo::orderBy('id', 'desc')->get()
            ]
        );
    }

    public function updated($property)
    {
        $day = array(
            'Sunday' => 'Minggu',
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu'
        );
        if ($property == 'appointment_date') {
            $this->day = $day[date('l', strtotime($this->appointment_date))];
        }
        if ($property == 'branch_id' && filled($this->branch_id)) {
            $this->appointment_date = NULL;
            $branch = Branch::with('poli')->where('id', $this->branch_id)->first();
            $this->polis = $branch->poli;
            $disabledDays = OperationalHour::where('branch_id', $this->branch_id)->where('active', false)->pluck('day')->toArray();

            $disabledDaysIndexes = array_map(function ($dayName) {
                $daysMap = [
                    "minggu" => 0,
                    "senin" => 1,
                    "selasa" => 2,
                    "rabu" => 3,
                    "kamis" => 4,
                    "jumat" => 5,
                    "sabtu" => 6
                ];
                return $daysMap[strtolower($dayName)];
            }, $disabledDays);

            $this->disabledDaysIndexes = json_encode($disabledDaysIndexes);
            $this->dispatch('refresh-disabledDay', disabledDaysIndexes: $this->disabledDaysIndexes);

        }

        if ($property == 'poli' && filled($this->poli)) {
            $this->checkups = Poli::with('checkups')->where('name', $this->poli)->first();
        }

        if ($this->appointment_date && $this->branch_id) {
            $this->estimated_arrivals = OperationalHour::where('branch_id', $this->branch_id)->where('day', strtolower($this->day))->where('active', true)->pluck('shift')->toArray();
        }


        if ($this->appointment_date && $this->branch_id && $this->estimated_arrival) {
            $operational_hour = OperationalHour::where('branch_id', $this->branch_id)->where('day', strtolower($this->day))->where('shift', $this->estimated_arrival)->first();

            $openDateTime = new DateTime($operational_hour->open ?? NULL);
            $closeDateTime = new DateTime($operational_hour->close ?? NULL);
            if ($closeDateTime <= $openDateTime) {
                $closeDateTime->modify('+1 day');
            }

            // Menghitung selisih waktu
            $interval = $openDateTime->diff($closeDateTime);

            // Mendapatkan total menit dari selisih waktu
            $totalMinutes = ($interval->h * 60) + $interval->i;
            // Membagi waktu menjadi interval 30 menit
            $intervalMinutes = 30;
            $intervals = [];

            $period = new DatePeriod($openDateTime, new DateInterval('PT' . $intervalMinutes . 'M'), $closeDateTime);

            foreach ($period as $dt) {
                $end = clone $dt;
                $end->add(new DateInterval('PT' . $intervalMinutes . 'M'));
                if ($end > $closeDateTime) {
                    break;
                }
                $intervals[] = $dt->format('H:i') . ' - ' . $end->format('H:i');
            }
            $this->estimated_hours = [];
            array_pop($intervals);
            $this->estimated_hours = $intervals;
        }
    }

    public function maskingData($data)
    {
        $first_three_chars = substr($data, 0, 3);
        $masked = $first_three_chars . str_repeat('*', max(strlen($data) - 3, 0));
        return $masked;
    }

    public function maskingperWord($data)
    {
        $words = explode(' ', $data); // Pisahkan kata-kata dalam string
        $maskedWords = array_map(function ($word) {
            $first_three_chars = substr($word, 0, 3); // Ambil 3 karakter pertama dari setiap kata
            $masked = $first_three_chars . str_repeat('*', max(strlen($word) - 3, 0)); // Masking sisa karakter
            return $masked;
        }, $words);

        return implode(' ', $maskedWords); // Gabungkan kembali kata-kata yang telah dimasking
    }

    public function maskingPhone($data)
    {
        $words = explode(' ', $data); // Pisahkan kata-kata dalam string
        $maskedWords = array_map(function ($word) {
            $length = strlen($word);
            $last_three_chars = substr($word, -3); // Ambil 3 karakter terakhir dari setiap kata
            $masked = str_repeat('*', max($length - 3, 0)) . $last_three_chars; // Masking karakter sebelumnya
            return $masked;
        }, $words);

        return implode(' ', $maskedWords); // Gabungkan kembali kata-kata yang telah dimasking
    }

    public function getPatient($key)
    {
        $phone_number = new PhoneNumber($this->phone_number_exist, 'ID');
        if ($key == 'nik') {
            if (!$this->dob_exist || !$this->nik_exist) {
                $this->alert('error', 'Tanggal Lahir dan NIK Wajib diisi', [
                    'toast' => false,
                    'position' => 'center',
                    'showConfirmButton' => true
                ]);
                return;
            }

            $patient = Patient::with('job')->where('nik', $this->nik_exist)->where('dob', Carbon::parse($this->dob_exist)->format('Y-m-d'))->first();
        } else {
            if (!$this->dob_exist || !$this->phone_number_exist) {
                $this->alert('error', 'Tanggal Lahir dan No HP Wajib diisi', [
                    'toast' => false,
                    'position' => 'center',
                    'showConfirmButton' => true
                ]);
                return;
            }
            $patient = Patient::with('job')->where('phone_number', 'ilike', '%' . $this->phone_number_exist . '%')->where('dob', Carbon::parse($this->dob_exist)->format('Y-m-d'))->first();
        }
        if ($patient) {
            $this->patient = $patient;
            $this->nik_exist = $this->maskingperWord($patient->nik);
            $this->name_exist = $this->maskingperWord($patient->name);
            $this->blood_type_exist = $patient->blood_type;
            $this->gender_exist = $patient->gender ? 'Laki-Laki' : 'Perempuan';
            $this->status_pernikahan_exist = $patient->status_pernikahan;
            $this->address_exist = $this->maskingperWord($patient->address);
            $this->city_exist = $this->maskingperWord($patient->city);
            $this->job_id_exist = $patient->job->name ?? '-';
            $this->phone_number_exist = $this->maskingPhone($patient->phone_number);
            $this->dispatch('refresh-data-patient');

        } else {

            $msg = $key == 'nik' ? 'Tidak ditemukan data pasien dengan NIK ' . $this->nik_exist : 'Tidak ditemukan data pasien dengan No. HP ' . $phone_number;

            $this->patient = null;
            $this->name_exist = null;
            $this->blood_type_exist = null;
            $this->gender_exist = null;
            $this->status_pernikahan_exist = null;
            $this->address_exist = null;
            $this->city_exist = null;
            $this->job_id_exist = null;
            $this->phone_number_exist = null;
            $this->alert('error', $msg, [
                'toast' => false,
                'position' => 'center',
                'showConfirmButton' => true
            ]);
        }
    }

    public function save()
    {
        if ($this->type_input == 'pasien_lama') {
            $this->nik = NULL;
            $this->phone_number = NULL;
        }
        try {
            $this->validate();
        } catch (ValidationException $e) {
            $errors = $e->validator->errors();
            $errorMessages = '';

            // Loop melalui semua pesan kesalahan dan tambahkan ke variabel $errorMessages
            foreach ($errors->all() as $message) {
                $errorMessages .= htmlspecialchars($message) . "\n";
            }

            // Mengonversi newline ke <br> dan memastikan tag HTML diproses dengan benar
            $errorMessages = nl2br($errorMessages);

            if ($errors->count() > 0) {
                $this->alert('error', 'Lengkapi seluruh data isian', [
                    'toast' => false,
                    'position' => 'center',
                    'html' => $errorMessages, // Menggunakan html agar tag <br> diinterpretasikan
                    'text' => $errorMessages
                ]);
                return;
            }
        }
        // $this->validate();
        if ($this->type_input == 'pasien_baru') {
            $phone_number = new PhoneNumber($this->phone_number, 'ID');
            try {
                $user = new User();
                $user->name = $this->name;
                $user->email = NULL;
                $user->password = bcrypt(substr($this->nik, 0, 3) . Carbon::parse($this->dob)->format('dm'));
                $user->role_id = 3;
                $user->save();

                $lastPatient = Patient::latest()->first();
                $patient = new Patient();

                if ($lastPatient == null) {
                    $patient->patient_number = '0001' . '.' . Carbon::parse($this->dob)->format('dmy');
                } else {
                    $patient->patient_number = str_pad((int)explode('.', $lastPatient->patient_number)[0] + 1, 4, "0", STR_PAD_LEFT) . '.' . Carbon::parse($this->dob)->format('dmy');
                }

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

                if ($this->city) {
                    $check_city = City::where('name', $this->city)->first();
                    if (!$check_city) {
                        $new_city = new City();
                        $new_city->name = $this->city;
                        $new_city->save();
                    }
                }
                $job_id = $check_job->id;

                $patient->name = $this->name;
                $patient->address = $this->address;
                $patient->nik = $this->nik;
                $patient->dob = Carbon::parse($this->dob);
                $patient->blood_type = $this->blood_type;
                $patient->gender = $this->gender;
                $patient->job_id = $job_id;
                $patient->city = $this->city;
                $patient->phone_number = $phone_number->formatE164();
                $patient->user_id = $user->id;
                $patient->status_pernikahan = $this->status_pernikahan;
                $patient->citizenship = 'WNI';
                $patient->save();

                $registration_latest = Registration::where('user_id', $user->id)->where('date', Carbon::parse($this->appointment_date)->format('Y-m-d'))->first();
                if (!$registration_latest) {
                    $registration = new Registration();
                    $registration->branch_id = $this->branch_id;
                    $registration->date = Carbon::parse($this->appointment_date);
                    $registration->estimated_arrival = $this->estimated_arrival;
                    $registration->poli = $this->poli;
                    $registration->user_id = $user->id;
                    $registration->estimated_hour = $this->estimated_hour;
                    $registration->checkup = $this->checkup;

                    $registration->finance_type = 'Umum';
                    $registration->save();
                } else {
                    $this->alert('info', 'Appointment gagal dibuat, karena anda sudah mambuat appointment dengan tanggal yang sama', [
                        'toast' => false,
                        'position' => 'center'

                    ]);
                    return;
                }

                $this->name = null;
                $this->nik = null;
                $this->dob = null;
                $this->blood_type = null;
                $this->gender = null;
                $this->status_pernikahan = null;
                $this->address = null;
                $this->city = null;
                $this->job_id = null;
                $this->phone_number = null;
                $this->appointment_date = null;
                $this->estimated_arrival = null;
                $this->poli = null;
                $this->branch_id = null;
                $this->alert('success', 'Appointment berhasil dibuat, silahkan datang sesuai tanggal appointment yang telah anda pilih', [
                    'toast' => false,
                    'position' => 'center'

                ]);

            } catch (\Throwable $th) {
                if (isset($user)) {
                    $user->delete();
                }
                if (isset($patient)) {
                    $patient->delete();
                }
                if (isset($registration)) {
                    $registration->delete();
                }
                $this->alert('error', 'Appointment gagal dibuat, silahkan ulangi beberapa saat lagi', [
                    'toast' => false,
                    'position' => 'center'
                ]);
            }
        } else {
            if ($this->patient) {
                $registration_latest = Registration::where('user_id', $this->patient->user_id)->where('date', Carbon::parse($this->appointment_date)->format('Y-m-d'))->first();
                if (!$registration_latest) {
                    $registration = new Registration();
                    $registration->branch_id = $this->branch_id;
                    $registration->date = Carbon::parse($this->appointment_date);
                    $registration->estimated_arrival = $this->estimated_arrival;
                    $registration->poli = $this->poli;
                    $registration->user_id = $this->patient->user_id;
                    $registration->estimated_hour = $this->estimated_hour;
                    $registration->checkup = $this->checkup;

                    $registration->finance_type = 'Umum';
                    $registration->save();
                } else {
                    $this->alert('info', 'Appointment gagal dibuat, karena anda sudah mambuat appointment dengan tanggal yang sama', [
                        'toast' => false,
                        'position' => 'center'

                    ]);
                    return;
                }

                $this->name_exist = null;
                $this->nik_exist = null;
                $this->dob_exist = null;
                $this->blood_type_exist = null;
                $this->gender_exist = null;
                $this->status_pernikahan_exist = null;
                $this->address_exist = null;
                $this->city_exist = null;
                $this->job_id_exist = null;
                $this->phone_number_exist = null;
                $this->appointment_date = null;
                $this->estimated_arrival = null;
                $this->poli = null;
                $this->branch_id = null;
                $this->dispatch('refresh-data-patient');
                $this->alert('success', 'Appointment berhasil dibuat, silahkan datang sesuai tanggal appointment yang telah anda pilih', [
                    'toast' => false,
                    'position' => 'center'

                ]);
            } else {
                $this->alert('error', 'Pastikan NIK anda sudah terdaftar di sistem kami, silahkan mencari data anda dengan NIK', [
                    'toast' => false,
                    'position' => 'center'

                ]);
            }
        }
    }
}
