<?php

namespace App\Livewire\StockEntry;

use App\Models\StockEntry;
use Livewire\Component;

class Edit extends Component
{
    public function mount(StockEntry $stockEntry)
    {
        //
    }

    public function render()
    {
        return view('livewire.stock-entry.edit');
    }
}
