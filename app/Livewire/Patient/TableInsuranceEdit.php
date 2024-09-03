<?php

namespace App\Livewire\Patient;

use App\Models\Insurance;
use Livewire\Attributes\On;
use Livewire\Component;

class TableInsuranceEdit extends Component
{
    public $patient;

    public function mount($patient)
    {
        $this->patient = $patient;
    }

    #[On('refresh-table-insurance')]
    public function refresh()
    {
    }

    public function render()
    {
        return view('livewire.patient.table-insurance-edit', [
            'insurances' => $this->patient->insurances,
            'uuid' => $this->patient->uuid
        ]);
    }

    public function destroy($uuid)
    {
        $insurance = Insurance::where('uuid', $uuid)->first();

        $insurance->delete();
        $this->dispatch('refresh-table-insurance')->self();
    }
}
