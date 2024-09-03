<?php

namespace App\Livewire\StockEntry;

use App\Models\Branch;
use App\Models\StockEntry;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search;
    public $filter_branch;
    public $filter_status;

    public function mount()
    {
        $this->filter_branch = auth()->user()->branch_filter;
    }

    public function render()
    {
        $this->authorize('viewAny', StockEntry::class);
        $stockEntry = StockEntry::query()
            ->select([
                'stock_entries.id',
                'stock_entries.uuid',
                'stock_entry_number',
                'purpose',
                'date',
                'status',
                'branches.name as name_branch',
                DB::raw('COUNT(stock_management_details.id) AS details_count'),
                DB::raw('SUM(stock_management_details.item_qty*stock_management_details.item_price) AS grand_total'),
            ])
            ->leftJoin('stock_management_details', 'stock_entry_id', '=', 'stock_entries.id')
            ->leftJoin('branches', 'branches.id', '=', 'branch_id')
            ->groupBy('stock_entries.id', 'branches.name')
            ->when($this->search, function ($query) {
                $query->where('stock_entry_number', 'ilike', '%' . $this->search . '%');
            })
            ->when($this->filter_branch != null, function ($query) {
                $query->where('branch_id', $this->filter_branch);
            })
            ->when($this->filter_status != null, function ($query) {
                $query->where('status', $this->filter_status);
            })
            ->orderBy('stock_entries.created_at', 'desc')
            ->paginate(10)
            ->onEachSide(3);

        if ($this->filter_branch || $this->search || $this->filter_status) {
            $this->resetPage();
        }
        return view('livewire.stock-entry.index', [
            'stockEntries' => $stockEntry,
            'branches' => Branch::all()
        ]);
    }
}
