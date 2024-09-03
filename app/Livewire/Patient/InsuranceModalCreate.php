<?php

namespace App\Livewire\Patient;

use Livewire\Attributes\Validate;
use LivewireUI\Modal\ModalComponent;
use Masmerise\Toaster\Toaster;

class InsuranceModalCreate extends ModalComponent
{
    #[Validate('required', as: 'Nama asuransi')]
    public $name;

    #[Validate('required', as: 'Nomor asuransi')]
    public $number;

    public function render()
    {
        return view('livewire.patient.insurance-modal-create');
    }

    public function save()
    {
        $this->validate();

        $this->dispatch('insert-insurance', name: $this->name, number: $this->number);
        $this->closeModal();
    }
}
