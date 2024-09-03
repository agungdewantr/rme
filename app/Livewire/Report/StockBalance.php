<?php

namespace App\Livewire\Report;

use App\Exports\StockBalanceExport;
use App\Models\Branch;
use App\Models\DrugMedDev;
use App\Models\StockLedger;
use Excel;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class StockBalance extends Component
{
    public $date;
    public $branch_id;
    public $item;

    public function mount()
    {
        $this->branch_id = auth()->user()->branch_filter;
    }

    public function render()
    {
        //subquery
        $subQuery = DB::table('stock_ledgers')
            ->select([
                'stock_ledgers.item_id',
                'stock_entries.branch_id',
                DB::raw('SUM(stock_ledgers.in) as in_qty'),
                DB::raw('SUM(stock_ledgers.out) as out_qty'),
            ])
            ->join('batches', 'stock_ledgers.batch_reference', '=', 'batches.batch_number')
            ->join('stock_entries', 'batches.stock_entry_id', '=', 'stock_entries.id')
            ->groupBy('stock_ledgers.item_id', 'stock_entries.branch_id');

        $results = DrugMedDev::query()
            ->select([
                'drug_med_devs.name as name',
                'branches.name as branch_name',
                'drug_med_devs.uom as uom',
                DB::raw('COALESCE(in_out.in_qty, 0) AS "in"'),
                DB::raw('COALESCE(in_out.out_qty, 0) AS out'),
                DB::raw('COALESCE(SUM(batches.qty), 0) AS qty'),
                DB::raw('COALESCE(AVG(CAST(batches.new_price AS INT)), 0) AS avg_new_price'),
            ])
            ->join('batches', 'drug_med_devs.id', '=', 'batches.item_id')
            ->join('stock_entries', 'batches.stock_entry_id', '=', 'stock_entries.id')
            ->join('branches', 'stock_entries.branch_id', '=', 'branches.id')
            ->joinSub($subQuery, 'in_out', function ($join) {
                $join->on('drug_med_devs.id', '=', 'in_out.item_id')->on('in_out.branch_id', '=', 'branches.id');
            })
            ->when(filled($this->branch_id), function ($query) {
                $query->where('branches.id', $this->branch_id);
            })
            ->when(filled($this->item), function ($query) {
                $query->where('drug_med_devs.id', $this->item);
            })
            ->groupBy('drug_med_devs.name', 'branches.name', 'in', 'out', 'uom')
            ->orderBy('drug_med_devs.name')
            ->get();

        return view('livewire.report.stock-balance', [
            'type' => 'Lap. Stock Balance',
            'items' => DrugMedDev::query()
                ->select('id', 'name')
                ->orderBy('name')
                ->get(),
            'branches' => Branch::query()
                ->select('id', 'name')
                ->oldest()
                ->get(),
            'result' => $results
        ]);
    }

    public function export()
    {
        $stock = StockLedger::query()
            ->with([
                'batch' => [
                    'stockEntry' => [
                        'branch'
                    ]
                ],
                'item'
            ])
            ->when($this->branch_id, function ($query) {
                $query->whereHas('batch', function ($query) {
                    $query->whereHas('stockEntry', function ($query) {
                        $query->where('branch_id', $this->branch_id);
                    });
                });
            })
            ->when($this->item, function ($query) {
                $query->whereHas('batch', function ($query) {
                    $query->where('item_id', $this->item);
                });
            })
            ->get();

        $result = $stock->groupBy([function ($stockLedger) {
            return $stockLedger['batch']['stockEntry']['branch_id'];
        }, function ($stockLedger) {
            return $stockLedger['batch']['item_id'];
        }])->values();

        return Excel::download(new StockBalanceExport($result), 'stock-balance.xlsx');
    }
}
