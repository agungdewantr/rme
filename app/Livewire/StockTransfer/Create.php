<?php

namespace App\Livewire\StockTransfer;

use App\Models\Account;
use App\Models\Batch;
use App\Models\Branch;
use App\Models\DrugMedDev;
use App\Models\HealthWorker;
use App\Models\Outcome;
use App\Models\PaymentMethod;
use App\Models\Setting;
use App\Models\StockEntry;
use App\Models\StockLedger;
use App\Models\StockManagementDetail;
use App\Models\StockTransfer;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Toaster;

class Create extends Component
{

    public $description;

    #[Validate('required', as: 'Cabang Penerima')]
    public $to_branch;
    public $payment_method_id = 1;

    #[Validate('required', as: 'Penerima')]
    public $receiver_id;
    #[Validate('required', as: 'Tanggal')]
    public $date;
    #[Validate('required', as: 'Status')]
    public $status;
    #[Validate('required', as: 'Jumlah Bayar')]
    public $amount;
    #[Validate('required', as: 'Grand Total')]
    public $grand_total;
    public $items;

    public function mount()
    {
        $this->date = date('Y-m-d');
        $this->items = [];
    }

    public function render()
    {
        return view('livewire.stock-transfer.create', [
            'branches' => Branch::all(),
            'drugMedDevsOption' => DrugMedDev::with(['batches' => function ($query) {
                $query->whereHas('stockEntry', function ($query) {
                    $query->where('branch_id', auth()->user()->branch_filter);
                });
            }])->orderBy('name', 'asc')->get(),
            'healthWorkers' => HealthWorker::where('position', 'Perawat')->get()
        ]);
    }

    public function getDrugMedDev($temp_id, $id)
    {
        if (empty($id)) {
            return;
        }

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
                ->where('stock_entries.branch_id', '=', auth()->user()->branch_filter)
                ->where('stock_entries.date','<=', $this->date)
                ->orderBy('stock_entries.date', 'desc')
                ->take(1),
                'expired_date' => Batch::query()
                ->select('batches.expired_date')
                ->leftJoin('stock_entries', 'stock_entries.id', '=', 'batches.stock_entry_id')
                ->whereRaw('batches.item_id = drug_med_devs.id')
                ->where('stock_entries.branch_id', '=', auth()->user()->branch_filter)
                ->where('stock_entries.date','<=', $this->date)
                ->orderBy('stock_entries.date', 'desc')
                ->take(1),
        ])
        ->leftJoin('batches', 'drug_med_devs.id', '=', 'batches.item_id')
        ->leftJoin('stock_entries', 'stock_entries.id', '=', 'batches.stock_entry_id')
        ->where('stock_entries.branch_id', auth()->user()->branch_filter)
        ->where('drug_med_devs.id', $id)
        ->groupBy('drug_med_devs.uom', 'drug_med_devs.id')
        ->first();
    //     $drugMedDev = DrugMedDev::select('drug_med_devs.name')
    // ->with(['batches' => function ($query) {
    //     $query->select('batches.item_id', 'batches.new_price')
    //           ->leftJoin('stock_entries', 'batches.stock_entry_id', '=', 'stock_entries.id')
    //           ->orderBy('stock_entries.date', 'desc');
    // }])
    // ->where('drug_med_devs.id', 1)
    // ->first();
        // $drugMedDev = DrugMedDev::with(['batches' => function ($query) {
        //     $query->whereHas('stockEntry', function ($query) {
        //         $query->where('branch_id', auth()->user()->branch_filter)
        //             ->where('date', '<=', $this->date);
        //     })
        //     // ->where('qty', '>', 0)
        //     ->orderBy(
        //         StockEntry::select('date')
        //             ->whereColumn('stock_entries.id', 'batches.stock_entry_id')
        //             ->orderBy('date', 'asc')
        //             ->limit(2)
        //     );
        // }, 'batches.stockEntry'])->find($id);

        if ($drugMedDev) {
            $this->dispatch('get-drug-med-dev-result', drugMedDev: $drugMedDev, temp_id: $temp_id);
        }
    }

    public function changeItemByDate($date)
    {
        $item_ids = array_map(function ($item) {
            return $item['item_id'];
        }, $this->items);

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
                ->where('stock_entries.branch_id', '=', auth()->user()->branch_filter)
                ->where('stock_entries.date','<=', $this->date)
                ->orderBy('stock_entries.date', 'desc')
                ->take(1),
                'expired_date' => Batch::query()
                ->select('batches.expired_date')
                ->leftJoin('stock_entries', 'stock_entries.id', '=', 'batches.stock_entry_id')
                ->whereRaw('batches.item_id = drug_med_devs.id')
                ->where('stock_entries.branch_id', '=', auth()->user()->branch_filter)
                ->where('stock_entries.date','<=', $this->date)
                ->orderBy('stock_entries.date', 'desc')
                ->take(1),
        ])
        ->leftJoin('batches', 'drug_med_devs.id', '=', 'batches.item_id')
        ->leftJoin('stock_entries', 'stock_entries.id', '=', 'batches.stock_entry_id')
        ->where('stock_entries.branch_id', auth()->user()->branch_filter)
        ->whereIn('drug_med_devs.id',  $item_ids)
        ->groupBy('drug_med_devs.uom', 'drug_med_devs.id')
        ->get();

        // DrugMedDev::with(['batches' => function ($query) use ($date) {
        //     $query->whereHas('stockEntry', function ($query) use ($date) {
        //         $query->where('branch_id', auth()->user()->branch_filter)
        //             ->where('date', '<=', $date);
        //     })->orderBy('id', 'desc');
        // }])->whereIn('id', $item_ids)->get();

        $newItems = [];

        foreach ($this->items as $i) {
            foreach ($drugMedDev as $d) {
                if ($d->id == $i['item_id']) {
                    $newItems[] = [
                        'temp_id' => Carbon::now()->format('YmdHisu'),
                        'item_id' => $d->id,
                        'name' => $d->name,
                        'price' => $d->new_price ?? 0,
                        'expired_date' => $d->expired_date ?? NULL,
                        'uom' => $d->uom,
                        'qty' => $i['qty']
                    ];
                }
            }
        }

        $this->items = [];
        $this->items = $newItems;
    }

    public function save()
    {
        $this->validate();
        if (auth()->user()->branch_filter == $this->to_branch) {
            Toaster::error('Stock Transfer gagal disimpan, cabang penerima harus berbeda');
            return;
        }

        foreach($this->items as $item){
            if(!is_numeric($item['qty'])){
                Toaster::error('Stock Transfer gagal disimpan, qty harus diisi');
                return;
            }
        }
        // if((int)filter_var($this->amount , FILTER_SANITIZE_NUMBER_INT) < (int)filter_var($this->grand_total , FILTER_SANITIZE_NUMBER_INT)){
        //     Toaster::error('Stock Transfer gagal disimpan, jumlah bayar kurang dari grand total');
        //     return;
        // }
        DB::beginTransaction();
        try {
            foreach ($this->items as $value) {
                $drugMedDev = DrugMedDev::find($value['item_id']);
                if (!$drugMedDev) {
                    Toaster::error('Stock Transfer gagal disimpan, obat/alkes tidak ditemukan');
                    // $this->notification = 'Pembayaran gagal disimpan, obat/alkes tidak ditemukan';
                    return;
                }

                if (Setting::whereField('is_can_minus')->first()->value == 0) {
                    $qtySum = Batch::query()
                        ->whereHas('stockEntry', function ($query) {
                            $query->where('branch_id', auth()->user()->branch_filter)
                                ->where('date', '<=', $this->date);
                        })
                        ->where('qty', '>', 0)
                        ->where('item_id', $drugMedDev->id)
                        ->orderBy('expired_date', 'asc')
                        ->sum('qty');
                    if ($qtySum < $value['qty']) {
                        Toaster::error('Stock Transfer gagal disimpan, stok obat kurang');
                        // $this->notification = 'Pembayaran gagal disimpan, stok obat kurang';
                        return;
                    }
                }
            }
            $latestStockTransfer = StockTransfer::latest()->first();
            if ($latestStockTransfer) {
                $oldStockEntryNumber = explode(".", $latestStockTransfer->stock_transfer_number)[2];
                if (explode(".", $latestStockTransfer->stock_transfer_number)[1] == date('my')) {
                    $newStockTransferNumber = "STF." . Carbon::parse($this->date)
                        ->setTimezone('Asia/Jakarta')
                        ->format('my') . '.' . str_pad(((int)$oldStockEntryNumber) + 1, 4, "0", STR_PAD_LEFT);
                } else {
                    $newStockTransferNumber = "STF." . Carbon::parse($this->date)
                        ->setTimezone('Asia/Jakarta')
                        ->format('my') . '.' . "0001";
                }
            } else {
                $newStockTransferNumber = "STF." . Carbon::parse($this->date)
                    ->setTimezone('Asia/Jakarta')
                    ->format('my') . '.' . "0001";
            }
            $stockTransfer = new StockTransfer();
            $stockTransfer->stock_transfer_number = $newStockTransferNumber;
            $stockTransfer->date = $this->date;
            $stockTransfer->status = $this->status;
            $stockTransfer->description = $this->description;
            $stockTransfer->payment_method_id = $this->payment_method_id;
            $stockTransfer->form_branch_id = auth()->user()->branch_filter;
            $stockTransfer->receiver_id = $this->receiver_id;
            $stockTransfer->amount =  (int)filter_var($this->amount , FILTER_SANITIZE_NUMBER_INT);
            $stockTransfer->grand_total = (int)filter_var($this->grand_total , FILTER_SANITIZE_NUMBER_INT);
            $stockTransfer->to_branch_id = $this->to_branch;
            $stockTransfer->grand_total = array_reduce($this->items, fn ($a, $b) => $a + $b['qty'] * (int)filter_var($b['price'], FILTER_SANITIZE_NUMBER_INT), 0);
            $stockTransfer->save();

            // foreach ($this->items as $value) {
            //     $qtyTmp = $value['qty'];
            //     $batchId = null;

            //     $isNotEmpty = true;
            //     while ($isNotEmpty) {
            //         $batch =  Batch::query()
            //             ->whereHas('stockEntry', function ($query) {
            //                 $query->where('branch_id', auth()->user()->branch_filter)
            //                     ->where('date', '<=', $this->date);
            //             })
            //             ->where('qty', '>', 0)
            //             ->where('item_id', $value['item_id'])
            //             ->orderBy('expired_date', 'asc')
            //             ->first();

            //         if ($batch) {
            //             StockLedger::create([
            //                 'document_reference' => $stockTransfer->stock_transfer_number,
            //                 'current_qty' => $batch->qty,
            //                 'in' => 0,
            //                 'out' => ($qtyTmp > $batch->qty ? $batch->qty : $qtyTmp),
            //                 'item_id' => $batch->item_id,
            //                 'qty' => $batch->qty - ($qtyTmp > $batch->qty ? $batch->qty : $qtyTmp),
            //                 'batch_reference' => $batch->batch_number
            //             ]);

            //             $qty_used = ($qtyTmp > $batch->qty ? $batch->qty : $qtyTmp);

            //             $qtyTmpTmp = $qtyTmp;
            //             $qtyTmp -= ($qtyTmp > $batch->qty ? $batch->qty : $qtyTmp);

            //             $batch->update([
            //                 'qty' => $batch->qty - ($qtyTmpTmp - $qtyTmp)
            //             ]);

            //             $batchId = $batch->id;

            //             $stockTransfer->batches()->attach($batch->id, [
            //                 'qty_used' => $qty_used
            //             ]);
            //         }
            //         if ($qtyTmp <= 0 || !$batch) {
            //             $isNotEmpty = false;
            //         }
            //     }

            //     $stockTransfer->items()->attach($value['item_id'], [
            //         'qty_total' => $value['qty']
            //     ]);
            // }



            // create SE Barang Masuk

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

            $stockEntryDateExist = StockEntry::with('items')->where('date', $this->date)->latest()->first();

            $newStockEntry = StockEntry::create([
                'purpose' => 'Barang Masuk',
                'stock_entry_number' => $newStockEntryNumber,
                'date' => Carbon::parse($this->date)->toDateString(),
                'status' => $this->status,
                'receiver_id' => $this->receiver_id, // auto kirana
                'description' => 'dibuat otomatis dari sistem setelah transfer stok (' . $newStockTransferNumber . ')',
                'supplier_id' => 1, //harusg
                'branch_id' => $this->to_branch,
                'grand_total' => array_reduce($this->items, fn ($a, $b) => $a + $b['qty'] * (int)filter_var($b['price'], FILTER_SANITIZE_NUMBER_INT), 0),
            ]);

            foreach ($this->items as $detail) {
                $drugMedDev = DrugMedDev::find($detail['item_id']);
                if ($drugMedDev) {
                    StockManagementDetail::create([
                        'stock_entry_id' => $newStockEntry->id,
                        'item_name' => $drugMedDev->name,
                        'item_uom' => $drugMedDev->uom,
                        'item_qty' => $detail['qty'],
                        'item_price' => str_replace('.', '', $detail['price']),
                        'item_expired_date' => $detail['expired_date'],
                    ]);
                }
            }

            if ($stockEntryDateExist?->items) {
                $latestBatch = $stockEntryDateExist->items->sortByDesc(function ($value) {
                    return $value->pivot->id;
                })->first()->pivot->batch_number;
                $newRunningNumber = (int) explode(substr($latestBatch, 0, 6), $latestBatch)[1];
            } else {
                $newRunningNumber = 0;
            }

            foreach ($this->items as $i) {
                $newBatchNumber = Carbon::parse($this->date)->setTimezone('Asia/Jakarta')->format('dmy') . str_pad(++$newRunningNumber, 4, "0", STR_PAD_LEFT);

                $newStockEntry->items()->attach($i['item_id'], [
                    'qty_ori' => $i['qty'],
                    'qty' => $i['qty'],
                    'expired_date' => Carbon::parse($i['expired_date'])->toDateString(),
                    'batch_number' => $newBatchNumber,
                    'new_price' => (int)filter_var($i['price'], FILTER_SANITIZE_NUMBER_INT)
                ]);

                StockLedger::create([
                    'document_reference' => $newBatchNumber,
                    'current_qty' => 0,
                    'in' => $i['qty'],
                    'out' => 0,
                    'qty' => $i['qty'],
                    'item_id' => $i['item_id'],
                    'batch_reference' => $newBatchNumber
                ]);
            }



            // Create SE barang keluar
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

            $stockEntryDateExist = StockEntry::with('items')->where('date', $this->date)->latest()->first();

            $newStockEntry = StockEntry::create([
                'purpose' => 'Barang Keluar',
                'stock_entry_number' => $newStockEntryNumber,
                'date' => Carbon::parse($this->date)->toDateString(),
                'status' => NULL,
                'receiver_id' => $this->receiver_id, // auto kirana
                'description' => 'dibuat otomatis dari sistem setelah transfer stok (' . $newStockTransferNumber . ')',
                'supplier_id' => NULL,
                'branch_id' => auth()->user()->branch_filter,
                'grand_total' => array_reduce($this->items, fn ($a, $b) => $a + $b['qty'] * (int)filter_var($b['price'], FILTER_SANITIZE_NUMBER_INT), 0),
            ]);

            foreach ($this->items as $detail) {
                $drugMedDev = DrugMedDev::find($detail['item_id']);
                if ($drugMedDev) {
                    StockManagementDetail::create([
                        'stock_entry_id' => $newStockEntry->id,
                        'item_name' => $drugMedDev->name,
                        'item_uom' => $drugMedDev->uom,
                        'item_qty' => $detail['qty'],
                        'item_price' => str_replace('.', '', $detail['price']),
                        'item_expired_date' => $detail['expired_date'],
                    ]);
                }
            }

            foreach ($this->items as $val) {
                $qtyTmp = $val['qty'];
                $batchId = null;

                $isNotEmpty = true;
                while ($isNotEmpty) {
                    $batch =  Batch::query()
                        ->whereHas('stockEntry', function ($query) {
                            $query->where('branch_id',  auth()->user()->branch_filter);
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

                        $qty_used = ($qtyTmp > $batch->qty ? $batch->qty : $qtyTmp);

                        $qtyTmpTmp = $qtyTmp;
                        $qtyTmp -= ($qtyTmp > $batch->qty ? $batch->qty : $qtyTmp);

                        $batch->update([
                            'qty' => $batch->qty - ($qtyTmpTmp - $qtyTmp)
                        ]);

                        $batchId = $batch->id;

                        $stockTransfer->batches()->attach($batch->id, [
                            'qty_used' => $qty_used
                        ]);
                    }
                    if ($qtyTmp <= 0 || !$batch) {
                        $isNotEmpty = false;
                    }
                }

                $stockTransfer->items()->attach($val['item_id'], [
                    'qty_total' => $val['qty']
                ]);
            }



            DB::commit();
            Toaster::success('Stock Transfer berhasil disimpan');
            return $this->redirectRoute('stock-transfer.index', navigate: true);
        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th->getMessage());
            Toaster::error('Gagal simpan. Coba beberapa saat lagi.');
        }
    }
}
