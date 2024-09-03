<?php

namespace App\Livewire\StockTransfer;

use App\Models\Branch;
use App\Models\StockTransfer;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    public $filter_status;
    public $filter_branch;
    public $search;

    public function mount()
    {
        $this->filter_branch = auth()->user()->branch_filter;

    }

    public function render()
    {
        $stockTransfer = StockTransfer::query()->with('batches','items')
        ->when($this->search, function ($query) {
            $query->where('stock_transfer_number', 'ilike', '%' . $this->search . '%');
        })
        ->when($this->filter_branch != null, function ($query) {
            $query->where('form_branch_id', $this->filter_branch);
        })
        ->orderBy('created_at', 'desc')
        ->paginate(10)
        ->onEachSide(3);

        if ($this->filter_status || $this->search) {
            $this->resetPage();
        }

        return view('livewire.stock-transfer.index', [
            'branches' => Branch::all(),
            'stockTransfers' => $stockTransfer

        ]);
    }
}
