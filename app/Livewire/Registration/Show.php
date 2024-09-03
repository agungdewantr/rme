<?php

namespace App\Livewire\Registration;

use App\Models\Registration;
use LivewireUI\Modal\ModalComponent;

class Show extends ModalComponent
{
    public ?Registration $registration;

    public function mount($uuid)
    {
        $this->registration = Registration::with('user', 'branch')->where('uuid', $uuid)->first();
    }

    public function render()
    {
        $this->authorize('view', $this->registration);
        return view('livewire.registration.show');
    }
}
