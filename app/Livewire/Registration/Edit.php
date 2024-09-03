<?php

namespace App\Livewire\Registration;

use App\Models\Branch;
use App\Models\CheckUp;
use App\Models\OperationalHour;
use App\Models\Poli;
use App\Models\Registration;
use App\Models\User;
use Carbon\Carbon;
use DateInterval;
use DatePeriod;
use DateTime;
use Livewire\Attributes\Validate;
use LivewireUI\Modal\ModalComponent;
use Masmerise\Toaster\Toaster;

class Edit extends ModalComponent
{
    public ?Registration $registration;

    #[Validate('required', as: 'Pasien')]
    public $user_id;

    #[Validate('required|date', as: 'Tanggal')]
    public $date;

    #[Validate('required', as: 'Estimasi Kedatangan')]
    public $estimated_arrival;

    #[Validate('required')]
    public $poli;

    #[Validate('required', as: 'Cabang')]
    public $branch_id;

    #[Validate('required', as: 'Jenis Pembiayaan')]
    public $finance_type;
    public $polis = [];
    #[Validate('required', as: 'Tujuan Pemeriksaan')]

    public $checkup;
    public $checkups = [];
    public $day;
    public $branch;
    public $estimated_hours = [];
    #[Validate('required', as: 'Estimasi Jam Kedatangan')]
    public $estimated_hour;

    #[Validate('required', as: 'Status')]
    public $status;

    public function mount($uuid)
    {
        $this->registration = Registration::with('user', 'branch')->where('uuid', $uuid)->first();
        $this->user_id = $this->registration->user_id;
        $this->date = $this->registration->date;
        $this->estimated_arrival = $this->registration->estimated_arrival;
        $this->poli = $this->registration->poli;
        $this->checkup = $this->registration->checkup;
        $this->branch_id = $this->registration->branch_id;
        $this->finance_type = $this->registration->finance_type;
        $this->status = $this->registration->status;

        $this->branch = Branch::with('poli')->where('id', $this->branch_id)->first();
        $this->polis = $this->branch->poli;
        $this->checkups = Poli::with('checkups')->where('name', $this->poli)->first();

        $day = array(
            'Sunday' => 'Minggu',
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu'
        );

        $this->day = $day[date('l', strtotime($this->date))];
        if ($this->date && $this->branch_id && $this->estimated_arrival) {
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

        $this->estimated_hour = $this->registration->estimated_hour;


        $this->dispatch('loading-edit', value: false);
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

        if ($property == 'date') {
            $this->day = $day[date('l', strtotime($this->date))];
        }

        if ($property == 'poli') {
            $this->checkups = Poli::with('checkups')->where('name', $this->poli)->first();
        }

        if ($this->date && $this->branch_id && $this->estimated_arrival) {
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

    public function render()
    {
        $this->authorize('update', $this->registration);
        return view('livewire.registration.edit', [
            'branches' => Branch::where('is_active', true)->get(),
            'users' => User::with('patient')->has('patient')->get()
        ]);
    }

    public function save()
    {
        $this->validate();
        $this->authorize('update', $this->registration);

        try {
            $this->registration->branch_id = $this->branch_id;
            $this->registration->date = Carbon::parse($this->date);
            $this->registration->estimated_arrival = $this->estimated_arrival;
            $this->registration->poli = $this->poli;
            // $this->registration->complaints = $this->complaints;
            $this->registration->finance_type = $this->finance_type;
            $this->registration->user_id = $this->user_id;
            $this->registration->estimated_hour = $this->estimated_hour;
            $this->registration->checkup = $this->checkup;
            $this->registration->status = $this->status;
            $this->registration->save();

            Toaster::success('Pendaftaran berhasil diubah');
            $this->dispatch('registration-refresh');
            $this->closeModal();
        } catch (\Throwable $th) {
            Toaster::error('Gagal ubah. Coba beberapa saat lagi');
        }
    }
}
