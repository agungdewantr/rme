<?php

namespace App\Livewire;

use App\Models\Branch;
use App\Models\Patient;
use App\Models\Registration;
use Auth;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;
use Session;
use Toaster;

class Dashboard extends Component
{
    use WithPagination;

    public $search;
    public $filter_status;
    public $filter_branch;
    public $filter_estimasi;

    #[On('registration-refresh')]
    public function refresh()
    {
    }

    public function mount()
    {
        $this->filter_branch = auth()->user()->branch_filter;
    }

    public function render()
    {
        if ($this->search) {
            $this->resetPage();
        }
        // return view('livewire.dashboard', [
        //     'registrations' => Registration::with(['user' => function ($query) {
        //         $query->withCount('medicalRecords');
        //     }, 'medicalRecord'])->whereDate('date', date('Y-m-d'))->paginate(10)
        // ]);
        // $total_patient = Patient::count();
        return view('livewire.dashboard', [
            'registrations' => Registration::with(['medicalRecord.transaction', 'firstEntry', 'branch', 'user.patient.firstEntry'])
                ->when($this->filter_branch != null, function ($query) {
                    $query->where('branch_id', $this->filter_branch);
                })
                ->whereDate('date', date('Y-m-d'))
                ->orderBy('queue_number', 'ASC')
                ->get(),
            // 'filtered_registrations' => Registration::whereHas('user', function ($query) {
            //     $query->where('name', 'ilike', "%{$this->search}%");
            // },)->when($this->filter_status != null, function ($query) {
            //     $query->where('status', $this->filter_status);
            // })->when($this->filter_branch != null, function ($query) {
            //     $query->where('branch_id', $this->filter_branch);
            // })->with(['medicalRecord.transaction', 'branch', 'firstEntry', 'user.patient.firstEntry', 'user' => function ($query) {
            //     $query->withCount('medicalRecords');
            // }])
            //     ->whereDate('date', date('Y-m-d'))
            //     ->orderBy('queue_number', 'ASC')
            //     ->paginate(25),
        'filtered_registrations' => Registration::whereHas('user', function ($query) {
            $query->where('name', 'ilike', "%{$this->search}%");
        })
        ->when($this->filter_status != null, function ($query) {
            $query->where('status', $this->filter_status);
        })
        ->when($this->filter_branch != null, function ($query) {
            $query->where('branch_id', $this->filter_branch);
        })
        ->when($this->filter_estimasi != null, function ($query) {
            $query->where('estimated_arrival', $this->filter_estimasi);
        })
        ->with(['medicalRecord.transaction', 'branch', 'firstEntry', 'user.patient.firstEntry', 'user' => function ($query) {
            $query->withCount('medicalRecords');
        }])
        ->whereDate('date', date('Y-m-d'))
        ->orderByRaw("
        CASE
        WHEN status = 'Selesai' THEN 4
        WHEN status = 'Batal' THEN 5
        WHEN status = 'Administrasi' AND queue_number IS NOT NULL THEN 2
        WHEN queue_number IS NULL AND status != 'Batal' THEN 3
        ELSE 0
        END,
        queue_number ASC
        ")
        ->orderBy('created_at', 'DESC')
        ->paginate(25),

            'total_patient' => Patient::count(),
            'branches' => Branch::all()
        ]);
    }

    public function assignQueue($id)
    {
        try {
            $lastRegistration = Registration::where('branch_id', auth()->user()->branch_filter ?? 1)->where('date', date('Y-m-d'))->where('queue_number', '!=', null)->orderBy('queue_number', 'DESC')->first();
            if (!$lastRegistration) {
                $queue = 1;
            } else {
                $queue = $lastRegistration->queue_number + 1;
            }
            $registration = Registration::find($id);
            $registration->queue_number = $queue;
            $registration->save();
        } catch (\Throwable $th) {
            Toaster::error('Gagal memasukkan antrian. Coba beberapa saat lagi');
        }
    }

    #[On('logout')]
    public function logout()
    {
        Auth::logout();

        Session::regenerate();
        Session::invalidate();

        return $this->redirectRoute('login');
    }

    public function cancelQueue($id)
    {
        try {
            //TODO: Ganti brach id kalo udah ada setting global kayak SKP atau simpeg
            $registration = Registration::find($id);
            $registration->status = 'Batal';
            $registration->save();
        } catch (\Throwable $th) {
            Toaster::error('Gagal menghapus antrian. Coba beberapa saat lagi');
        }
    }

    public function check()
    {
        $this->dispatch('check');
    }

    public function resetQueue()
    {
        try {
            $registrations = Registration::where('branch_id', auth()->user()->branch_filter)->where('date', date('Y-m-d'))->get();
            foreach ($registrations as $registration) {
                $registration->queue_number = null;
                $registration->save();
            }
            Toaster::success('Antrian berhasil direset');
        } catch (\Throwable $th) {
            //throw $th;
            Toaster::error('Gagal reset antrian. Coba beberapa saat lagi');
        }
    }
}
