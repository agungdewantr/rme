<?php

namespace App\Livewire\Report;

use App\Exports\StockLedgerExport;
use App\Models\Batch;
use App\Models\Branch;
use App\Models\DrugMedDev;
use App\Models\StockLedger as ModelsStockLedger;
use Carbon\Carbon;
use Excel;
use Livewire\Component;

class StockLedger extends Component
{
    public $date;
    public $branch_id;
    public $item_id;
    public $batch;

    public function updated($property, $value)
    {
        if ($property == 'date') {
            if (is_array($value)) {
                $this->date = array_map(function ($val) {
                    return Carbon::parse($val)->setTimezone('Asia/Jakarta')->toDateString();
                }, $value);
            }
        }
    }

    public function mount()
    {
        $this->branch_id = auth()->user()->branch_filter;
        $this->date = [date('Y-m-01'), date('Y-m-t')];
    }

    public function render()
    {
        return view('livewire.report.stock-ledger', [
            'type' => 'Lap. Stock Ledger',
            'items' => DrugMedDev::query()
                ->select('id', 'name')
                ->orderBy('name', 'asc')
                ->get(),
            'branches' => Branch::query()
                ->select('id', 'name')
                ->get(),
            'batches' => Batch::query()
                ->select('id', 'batch_number')
                ->oldest()
                ->get(),
            'stockLedgers' => ModelsStockLedger::query()
                ->with([
                    'item' => function ($query) {
                        $query->select('id', 'name');
                    },
                    'batch' => function ($query) {
                        $query->select('id', 'new_price', 'stock_entry_id', 'batch_number')
                            ->with([
                                'stockEntry' => function ($query) {
                                    $query->select('id', 'branch_id')
                                        ->with([
                                            'branch' => function ($query) {
                                                $query->select('id', 'name');
                                            }
                                        ]);
                                }
                            ]);
                    },

                ])
                ->when($this->branch_id, function ($query) {
                    $query->whereHas('batch', function ($query) {
                        $query->whereHas('stockEntry', function ($query) {
                            $query->where('branch_id', $this->branch_id);
                        });
                    });
                })
                ->when($this->batch, function ($query) {
                    $query->where('batch_reference', $this->batch);
                })
                ->when($this->item_id, function ($query) {
                    $query->where('item_id', $this->item_id);
                })
                ->when($this->date, function ($query) {
                    $query->whereDate('created_at', '>=', $this->date[0])->whereDate('created_at', '<=', $this->date[1]);
                })
                ->orderBy('id', 'asc')
                ->get()
        ]);
    }

    public function export()
    {
        $stockLedgers = ModelsStockLedger::query()
            ->with([
                'item' => function ($query) {
                    $query->select('id', 'name');
                },
                'batch' => function ($query) {
                    $query->select('id', 'new_price', 'stock_entry_id', 'batch_number')
                        ->with([
                            'stockEntry' => function ($query) {
                                $query->select('id', 'branch_id')
                                    ->with([
                                        'branch' => function ($query) {
                                            $query->select('id', 'name');
                                        }
                                    ]);
                            }
                        ]);
                },

            ])
            ->when($this->branch_id, function ($query) {
                $query->whereHas('batch', function ($query) {
                    $query->whereHas('stockEntry', function ($query) {
                        $query->where('branch_id', $this->branch_id);
                    });
                });
            })
            ->when($this->batch, function ($query) {
                $query->where('batch_reference', $this->batch);
            })
            ->when($this->item_id, function ($query) {
                $query->where('item_id', $this->item_id);
            })
            ->when($this->date, function ($query) {
                $query->whereDate('created_at', '>=', $this->date[0])->whereDate('created_at', '<=', $this->date[1]);
            })
            ->oldest()
            ->get();

        return Excel::download(new StockLedgerExport($stockLedgers), 'Lap. Stock Ledger.xlsx');
    }
}
