<?php

namespace App\Livewire\StockEntry;

use App\Models\Batch;
use App\Models\Branch;
use App\Models\DrugMedDev;
use App\Models\HealthWorker;
use App\Models\StockEntry;
use App\Models\StockLedger;
use App\Models\StockManagementDetail;
use App\Models\Supplier;
use Carbon\Carbon;
use DB;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Toaster;

class Create extends Component
{
    #[Validate('required', as: 'Tujuan')]
    public $purpose;
    #[Validate('required', as: 'Tanggal')]
    public $date;
    public $status;
    public $supplier;
    #[Validate('required', as: 'Cabang')]
    public $branch_id;
    #[Validate('required', as: 'Perawat')]
    public $receiver_id;
    public $description;
    public $batches;

    public function mount()
    {
        $this->date = date('Y-m-d');
        $this->batches = [];
        $this->branch_id = auth()->user()->branch_filter;
    }

    public function render()
    {
        $this->authorize('create', StockEntry::class);

        return view('livewire.stock-entry.create', [
            'nurses' => HealthWorker::where('position', 'Perawat')->orderBy('id', 'asc')->get(),
            'branches' => Branch::orderBy('id', 'asc')->get(),
            'suppliers' => Supplier::orderBy('id', 'asc')->get(),
            'items' => DrugMedDev::orderBy('id', 'asc')->get()
        ]);
    }

    public function fetchItem($id, int $branch): void
    {
        $drugMedDev = DrugMedDev::query()
            ->select([
                'drug_med_devs.name as name',
                'drug_med_devs.id',
                'drug_med_devs.uom',
                DB::raw('SUM(batches.qty) as qty'),
            ])
            ->addSelect([
                'new_price' => Batch::query()
                    ->select('batches.new_price')
                    ->leftJoin('stock_entries', 'stock_entries.id', '=', 'batches.stock_entry_id')
                    ->whereRaw('batches.item_id = drug_med_devs.id')
                    ->where('stock_entries.branch_id', '=', $branch)
                    ->orderBy('batches.id', 'desc')
                    ->take(1)
            ])
            ->leftJoin('batches', 'drug_med_devs.id', '=', 'batches.item_id')
            ->leftJoin('stock_entries', 'stock_entries.id', '=', 'batches.stock_entry_id')
//            ->where('stock_entries.branch_id', $branch)
            ->where('drug_med_devs.id', $id)
            ->groupBy('drug_med_devs.uom', 'drug_med_devs.id')
            ->first();

//        dd($drugMedDev);
        $this->dispatch('fetch-item', item: $drugMedDev);
    }

    public function getItems($supplier, $branch)
    {
        $items = Batch::query()
            ->with('item')
            ->join('drug_med_devs', 'batches.item_id', '=', 'drug_med_devs.id') // Gabungkan tabel batch dengan tabel items
            ->when($supplier != '', function ($query) use ($supplier) {
                $query->whereHas('stockEntry', function ($query) use ($supplier) {
                    $query->whereHas('supplier', function ($query) use ($supplier) {
                        $query->where('name', $supplier);
                    });
                });
            })
            ->when($branch != '', function ($query) use ($branch) {
                $query->whereHas('stockEntry', function ($query) use ($branch) {
                    $query->where('branch_id', $branch);
                });
            })
            ->where('qty', '>', 0)
            ->orderBy('drug_med_devs.name', 'ASC') // Urutkan berdasarkan nama item ASC
            ->select('batches.*') // Pilih semua kolom dari tabel batches
            ->get();

        // Batch::query()
        //     ->with('item')
        //     ->when($supplier != '', function ($query) use ($supplier) {
        //         $query->whereHas('stockEntry', function ($query) use ($supplier) {
        //             $query->whereHas('supplier', function ($query) use ($supplier) {
        //                 $query->where('name', $supplier);
        //             });
        //         });
        //     })
        //     ->when($branch != '', function ($query) use ($branch) {
        //         $query->whereHas('stockEntry', function ($query) use ($branch) {
        //             $query->where('branch_id', $branch);
        //         });
        //     })
        //     ->get();

        // dd($items);


        $this->dispatch('get-items', items: $items);
    }

    /**
     * @throws \Throwable
     */
    public function save()
    {
        $this->authorize('create', StockEntry::class);

        $this->validate();

        $hasNull = false;
        foreach ($this->batches as $value) {
            foreach ($value as $batch) {
                if ($batch == null) {
                    $hasNull = true;
                }
            }
        }

        if ($hasNull || !$this->batches) {
            Toaster::error('Gagal simpan. Ada batch yang kosong');
            return 0;
        }

        $newStockEntry = null;

        DB::beginTransaction();
        try {
            $latestStockEntry = StockEntry::latest()->first();
            if ($latestStockEntry) {
                $oldStockEntryNumber = explode(".", $latestStockEntry->stock_entry_number)[2];
                if (explode(".", $latestStockEntry->stock_entry_number)[1] == date('my')) {
                    $newStockEntryNumber = "STE." . Carbon::parse($this->date)
                            ->setTimezone('Asia/Jakarta')
                            ->format('my') . '.' . str_pad(((int)$oldStockEntryNumber) + 1, 4, "0", STR_PAD_LEFT);
                } else {
                    $newStockEntryNumber = "STE." . Carbon::parse($this->date)
                            ->setTimezone('Asia/Jakarta')
                            ->format('my') . '.' . "0001";
                }
            } else {
                $newStockEntryNumber = "STE." . Carbon::parse($this->date)
                        ->setTimezone('Asia/Jakarta')
                        ->format('my') . '.' . "0001";
            }

            $supplier = Supplier::where('name', $this->supplier)->first();
            // if (!$supplier) {
            //     $supplier = Supplier::create([
            //         'name' => $this->supplier
            //     ]);
            // }

            $stockEntryDateExist = StockEntry::with('items')->has('items')->where('date', $this->date)->latest()->first();

            $newStockEntry = StockEntry::create([
                'purpose' => $this->purpose,
                'stock_entry_number' => $newStockEntryNumber,
                'date' => Carbon::parse($this->date)->toDateString(),
                'status' => $this->status,
                'receiver_id' => $this->receiver_id,
                'description' => $this->description,
                'supplier_id' => $supplier?->id,
                'branch_id' => $this->branch_id,
                'grand_total' => array_reduce($this->batches, fn($a, $b) => $a + $b['qty'] * (int)filter_var($b['new_price'], FILTER_SANITIZE_NUMBER_INT), 0),
            ]);

            foreach ($this->batches as $detail) {
                $drugMedDev = DrugMedDev::find($detail['item_id']);
                if ($drugMedDev) {
                    StockManagementDetail::create([
                        'stock_entry_id' => $newStockEntry->id,
                        'item_name' => $drugMedDev->name,
                        'item_uom' => $drugMedDev->uom,
                        'item_qty' => $detail['qty'],
                        'item_price' => str_replace('.', '', $detail['new_price']),
                        'item_expired_date' => $detail['expired_date'],
                    ]);
                }
            }

            if ($this->purpose == 'Barang Opname') {
                if ($stockEntryDateExist?->items) {
                    $latestBatch = $stockEntryDateExist->items->sortByDesc(function ($value) {
                        return $value->pivot->id;
                    })->first()->pivot->batch_number;

                    // DB::rollBack();
                    // dd(explode(substr($latestBatch, 0, 6), $latestBatch)[1]);
                    $newRunningNumber = (int)(explode(substr($latestBatch, 0, 6), $latestBatch)[1]);
                } else {
                    $newRunningNumber = 0;
                }

                foreach ($this->batches as $b) {
                    $batch = Batch::find($b['id']);

                    if ($batch) {
                        if ($batch['qty'] > $b['qty']) {
                            StockLedger::create([
                                'document_reference' => $batch['batch_number'],
                                'batch_reference' => $batch['batch_number'],
                                'current_qty' => $batch['qty'],
                                'in' => 0,
                                'out' => $batch['qty'] - $b['qty'],
                                'qty' => $b['qty'],
                                'item_id' => $batch['item_id'],
                            ]);
                        } elseif ($batch['qty'] != $b['qty']) {
                            StockLedger::create([
                                'document_reference' => $batch['batch_number'],
                                'batch_reference' => $batch['batch_number'],
                                'current_qty' => $batch['qty'],
                                'in' => $b['qty'] - $batch['qty'],
                                'out' => 0,
                                'qty' => $b['qty'],
                                'item_id' => $batch['item_id'],
                            ]);
                        }

                        $batch->update([
                            'qty_ori' => $b['qty'],
                            'qty' => $b['qty'],
                            'expired_date' => Carbon::parse($b['expired_date'])->toDateString(),
                            'new_price' => (int)filter_var($b['new_price'], FILTER_SANITIZE_NUMBER_INT)
                        ]);

                        $newStockEntry->batches()->attach($batch['id']);
                    } else {
                        $newBatchNumber = Carbon::parse($this->date)->setTimezone('Asia/Jakarta')->format('dmy') . str_pad(++$newRunningNumber, 4, "0", STR_PAD_LEFT);

                        $newStockEntry->items()->attach($b['item_id'], [
                            'qty_ori' => $b['qty'],
                            'qty' => $b['qty'],
                            'expired_date' => Carbon::parse($b['expired_date'])->toDateString(),
                            'batch_number' => $newBatchNumber,
                            'new_price' => (int)filter_var($b['new_price'], FILTER_SANITIZE_NUMBER_INT)
                        ]);

                        StockLedger::create([
                            'document_reference' => $newBatchNumber,
                            'current_qty' => 0,
                            'in' => $b['qty'],
                            'out' => 0,
                            'qty' => $b['qty'],
                            'item_id' => $b['item_id'],
                            'batch_reference' => $newBatchNumber
                        ]);
                    }
                }
                DB::commit();

                Toaster::success('Berhasil simpan');
                return $this->redirectRoute('stock-entry.index', navigate: true);
            }
            if ($stockEntryDateExist?->items) {
                $latestBatch = $stockEntryDateExist->items->sortByDesc(function ($value) {
                    return $value->pivot->id;
                })->first()->pivot->batch_number;
                $newRunningNumber = (int)explode(substr($latestBatch, 0, 6), $latestBatch)[1];
            } else {
                $newRunningNumber = 0;
            }

            foreach ($this->batches as $val) {
                $newBatchNumber = Carbon::parse($this->date)->setTimezone('Asia/Jakarta')->format('dmy') . str_pad(++$newRunningNumber, 4, "0", STR_PAD_LEFT);

                if ($this->purpose != 'Barang Keluar') {
                    $currObat = DrugMedDev::find($val['item_id']);
                    $currObat?->update([
                        'purchase_price' => (int)filter_var($val['new_price'], FILTER_SANITIZE_NUMBER_INT),
                    ]);

                    $newStockEntry->items()->attach($val['item_id'], [
                        'qty_ori' => $val['qty'],
                        'qty' => $val['qty'],
                        'expired_date' => Carbon::parse($val['expired_date'])->toDateString(),
                        'batch_number' => $newBatchNumber,
                        'new_price' => (int)filter_var($val['new_price'], FILTER_SANITIZE_NUMBER_INT)
                    ]);

                    StockLedger::create([
                        'document_reference' => $newBatchNumber,
                        'current_qty' => 0,
                        'in' => $val['qty'],
                        'out' => 0,
                        'qty' => $val['qty'],
                        'item_id' => $val['item_id'],
                        'batch_reference' => $newBatchNumber
                    ]);
                } else {
                    $qtyTmp = $val['qty'];
                    $batchId = null;

                    $isNotEmpty = true;
                    while ($isNotEmpty) {
                        $batch = Batch::query()
                            ->whereHas('stockEntry', function ($query) {
                                $query->where('branch_id', auth()->user()->branch_filter);
                            })
                            ->where('qty', '>', 0)
                            ->where('item_id', $val['item_id'])
                            ->orderBy('expired_date', 'asc')
                            ->first();

                        if ($batch) {
                            StockLedger::create([
                                'document_reference' => $newStockEntryNumber,
                                'current_qty' => $batch->qty,
                                'in' => 0,
                                'out' => ($qtyTmp > $batch->qty ? $batch->qty : $qtyTmp),
                                'item_id' => $batch->item_id,
                                'qty' => $batch->qty - ($qtyTmp > $batch->qty ? $batch->qty : $qtyTmp),
                                'batch_reference' => $batch->batch_number
                            ]);

                            $qtyTmpTmp = $qtyTmp;
                            $qtyTmp -= ($qtyTmp > $batch->qty ? $batch->qty : $qtyTmp);

                            $batch->update([
                                'qty' => $batch->qty - ($qtyTmpTmp - $qtyTmp)
                            ]);

                            $batchId = $batch->id;
                        }
                        if ($qtyTmp <= 0 || !$batch) {
                            $isNotEmpty = false;
                        }
                    }
                }

            }
            DB::commit();

            Toaster::success('Berhasil simpan');
            return $this->redirectRoute('stock-entry.index', navigate: true);
        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th);
            Toaster::error('Gagal simpan. Coba beberapa saat lagi.');
        }
    }
}
