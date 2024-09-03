<?php

namespace App\Livewire\Report;

use App\Exports\IncomePerPatientExport;
use App\Models\Branch;
use App\Models\HealthWorker;
use App\Models\Transaction;
use App\Models\User;
use Excel;
use Livewire\Component;

class IncomePatient extends Component
{
    public $doctor_id;
    public $date;
    public $poli;
    public $type = 'Lap. Pendapatan';
    public $search;
    public $branch_id;

    public function mount()
    {
        $this->branch_id = auth()->user()->branch_filter;
    }

    public function render()
    {
        return view('livewire.report.income-patient', [
            'type' => 'Lap. Pendapatan Per Pasien',
            'branch_id' => auth()->user()->branch_filter,
            'transactions' => Transaction::query()
                ->with(['patient', 'doctor', 'drugMedDevs', 'actions', 'medicalRecord.registration'])
                ->where('date', empty($this->date) ? date('Y-m-d') : $this->date)
                ->when($this->doctor_id, function ($query) {
                    $query->where('doctor_id', $this->doctor_id);
                })
                ->when($this->search, function ($query) {
                    $query->whereHas('patient', function ($query) {
                        $query->where('name', 'ilike', "%{$this->search}%");
                    });
                })
                ->get(),
            'doctors' => User::whereHas('healthWorker', function ($query) {
                $query->where('position', 'Dokter');
            })->get(),
            'branches' => Branch::all()
        ]);
    }

    public function export()
    {
        $transaction = Transaction::query()
            ->with(['patient', 'doctor', 'drugMedDevs', 'actions', 'medicalRecord.registration'])
            ->where('date', empty($this->date) ? date('Y-m-d') : $this->date)
            ->when($this->doctor_id, function ($query) {
                $query->where('doctor_id', $this->doctor_id);
            })
            ->when($this->search, function ($query) {
                $query->whereHas('patient', function ($query) {
                    $query->where('name', 'ilike', "%{$this->search}%");
                });
            })
            ->get();

        return Excel::download(new IncomePerPatientExport($transaction), 'Lap. Pendapatan Per Pasien.xlsx');
    }

    public function report_type($type)
    {
        $this->type = $type;
        $this->date = null;
        $this->doctor_id = null;
        $this->poli = null;
        $this->dispatch('report-doctor-refresh');
    }
}
