<?php

namespace App\Livewire\DrugAndMedDev;

use App\Models\ActivityLog;
use App\Models\DrugMedDev;
use Livewire\Component;

class Show extends Component
{
    public ?DrugMedDev $drugMedDev;

    public function mount(DrugMedDev $drugMedDev)
    {
        $this->drugMedDev = $drugMedDev;
    }

    public function render()
    {
        $this->authorize('view', $this->drugMedDev);
        return view('livewire.drug-and-med-dev.show', ['logs' => ActivityLog::where('model_id', $this->drugMedDev->id)->where('model', 'DrugMedDev')->latest()->get()]);
    }
}
