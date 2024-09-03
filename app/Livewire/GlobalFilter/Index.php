<?php

namespace App\Livewire\GlobalFilter;

use App\Models\Branch;
use App\Models\HealthWorker;
use Auth;
use Livewire\Attributes\Validate;
use LivewireUI\Modal\ModalComponent;

class Index extends ModalComponent
{
    public $branch;
    public $doctor;

    public function rules(): array
    {
        if (auth()->user()->role->name != 'doctor') {
            return [
                'branch' => 'required',
                'doctor' => 'required',
            ];
        }

        return [
            'branch' => 'required',
            'doctor' => 'nullable'
        ];
    }

    public function validationAttributes(): array
    {
        return [
            'branch' => 'Cabang',
            'doctor' => 'Dokter'
        ];
    }

    public static function closeModalOnEscape(): bool
    {
        return false;
    }
    public static function closeModalOnClickAway(): bool
    {
        return false;
    }
    public function render()
    {
        return view('livewire.global-filter.index', [
            'branches' => Branch::all(),
            'doctors' => HealthWorker::where('position', 'Dokter')->get()
        ]);
    }

    public function close()
    {
        $this->closeModal();
        Auth::logout();
    }

    public function save()
    {
        $this->validate();

        auth()->user()->branch_filter = $this->branch;
        auth()->user()->doctor_filter = $this->doctor;
        auth()->user()->save();

        return $this->redirectIntended("/dashboard");
    }
}
