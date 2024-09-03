<?php

namespace App\Livewire\Outcome;

use App\Models\ActivityLog;
use App\Models\Outcome;
use App\Models\StockEntry;
use Livewire\Component;

class Show extends Component
{
    public $outcome;
    public $references;

    public function mount($uuid)
    {
        $this->outcome = Outcome::with('detailOutcome','account','supplier','detailOutcome.stockEntry','detailOutcome.stockEntry.items')->where('uuid', $uuid)->first();
    }

    public function render()
    {
        return view('livewire.outcome.show',[
            'logs' => ActivityLog::where('model_id', $this->outcome->id)->where('model', 'Outcome')->latest()->get()
        ]);
    }
}
