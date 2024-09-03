<?php

namespace App\Livewire\Patient;

use App\Models\Insurance;
use App\Models\Patient;
use Livewire\Attributes\Validate;
use LivewireUI\Modal\ModalComponent;
use Masmerise\Toaster\Toaster;

class InsuranceModalEdit extends ModalComponent
{
    public $uuid;

    #[Validate('required', as: 'Nama asuransi')]
    public $name;

    #[Validate('required', as: 'Nomor asuransi')]
    public $number;

    public function mount($uuid)
    {
        $this->uuid = $uuid;
    }

    public function render()
    {
        return view('livewire.patient.insurance-modal-edit');
    }

    public function save()
    {
        $this->validate();

        $patient = Patient::where('uuid', $this->uuid)->first();
        if (!$patient) {
            Toaster::error('Data pasien tidak ada');
            return;
        }

        $insurance = new Insurance();
        $insurance->name = $this->name;
        $insurance->number = $this->number;
        $insurance->patient_id = $patient->id;
        $insurance->save();

        $this->dispatch('refresh-table-insurance');
        $this->closeModal();
    }
}
