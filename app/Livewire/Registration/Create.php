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
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\Validate;
use LivewireUI\Modal\ModalComponent;
use Masmerise\Toaster\Toaster;
use Symfony\Component\Console\Output\ConsoleOutput;

class Create extends ModalComponent
{
    #[Validate('required', as: 'Pasien')]
    public $user_id;

    #[Validate('required|date', as: 'Tanggal')]
    public $date;

    #[Validate('required', as: 'Estimasi Waktu Kedatangan')]
    public $estimated_arrival;

    public $estimated_arrivals = [];

    #[Validate('required', as: 'Jenis Pembiayaan')]
    public $finance_type = 'Umum';

    #[Validate('required', as: 'Lokasi Klinik')]
    public $branch_id;


    #[Validate('required', as: 'Poli Tujuan')]
    public $poli;
    public $polis = [];
    #[Validate('required', as: 'Tujuan Pemeriksaan')]
    public $checkup;
    public $checkups = [];
    public $day;
    public $branch;
    public $estimated_hours = [];
    #[Validate('required', as: 'Estimasi Jam Kedatangan')]
    public $estimated_hour;
    public function mount()
    {
        $this->branch_id = auth()->user()->branch_filter;
        $this->date =  now()->format("Y-m-d");
        $this->branch = Branch::with('poli')->where('id', $this->branch_id)->first();
        $this->polis = $this->branch->poli()->where('is_active',true)->get();


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
        $this->estimated_arrivals = OperationalHour::where('branch_id', $this->branch_id)->where('day', strtolower($this->day))->where('active',true)->pluck('shift')->toArray();

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

        if($property == 'date'){
            $this->day = $day[date('l', strtotime($this->date))];
        }
        if($this->date && $this->branch_id){
            $this->estimated_arrivals = OperationalHour::where('branch_id', $this->branch_id)->where('day', strtolower($this->day))->where('active',true)->pluck('shift')->toArray();
        }
        if($property == 'poli'){
            $this->checkups = Poli::with('checkups')->where('name',$this->poli)->first();
        }

        if($this->date && $this->branch_id && $this->estimated_arrival){
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
        $this->authorize('create', Registration::class);
        $this->dispatch('loading', value: false);
        return view('livewire.registration.create', [
            'branches' => Branch::where('is_active', true)->get(),
            'users' => User::with('patient', 'patient.registration')
            ->has('patient')
            ->whereDoesntHave('patient.registration', function ($query) {
                $query->whereDate('date', Carbon::today()->format('Y-m-d'));
            })
            ->get()
        ]);
    }

    public function save()
    {
        $this->validate();
        $this->authorize('create', Registration::class);

        try {
            DB::beginTransaction();
            $registration = new Registration();
            $registration->branch_id = $this->branch_id;
            $registration->date = Carbon::parse($this->date);
            $registration->estimated_arrival = $this->estimated_arrival;
            $registration->poli = $this->poli;
            $registration->user_id = $this->user_id;
            $registration->finance_type = $this->finance_type;
            $registration->estimated_hour = $this->estimated_hour;
            $registration->checkup = $this->checkup;
            $registration->save();
            DB::commit();
            Toaster::success('Pendaftaran berhasil dibuat');
            $this->dispatch('registration-refresh');
            $this->closeModal();
        } catch (\Throwable $th) {
            DB::rollback();
            Toaster::error('Gagal buat. Coba beberapa saat lagi. ' . $th->getMessage());
        }
    }
}
