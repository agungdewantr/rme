<?php

namespace App\Livewire\HealthWorker;

use App\Models\HealthWorker;
use LivewireUI\Modal\ModalComponent;

class Show extends ModalComponent
{
    public $uuid;
    public function mount($uuid)
    {
        $this->uuid = $uuid;
    }

    public function render()
    {
        $this->authorize('view', HealthWorker::where('uuid', $this->uuid)->first());
        return view('livewire.health-worker.show', [
            'healthWorker' => HealthWorker::where('uuid', $this->uuid)->first()
        ]);
    }
}
