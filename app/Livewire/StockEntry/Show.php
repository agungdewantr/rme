<?php

namespace App\Livewire\StockEntry;

use App\Models\Branch;
use App\Models\HealthWorker;
use App\Models\StockEntry;
use App\Models\Supplier;
use Livewire\Component;

class Show extends Component
{
    public $stock_entry;

    public function mount(StockEntry $stockEntry)
    {
        $this->stock_entry = $stockEntry->load('details');
    }

    public function render()
    {
        $this->authorize('view', $this->stock_entry);

        return view('livewire.stock-entry.show', [
            'stockEntry' => $this->stock_entry,
            'nurses' => HealthWorker::where('position', 'Perawat')->get(),
            'suppliers' => Supplier::all(),
            'branches' => Branch::all()
        ]);
    }
}
