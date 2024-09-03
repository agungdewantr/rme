<?php

namespace App\Livewire\Outcome;

use App\Models\Account;
use App\Models\ActivityLog;
use App\Models\Branch;
use App\Models\CategoryOutcome;
use App\Models\DetailOutcome;
use App\Models\Outcome;
use App\Models\StockEntry;
use App\Models\Supplier;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Toaster;

class Edit extends Component
{
    #[Validate('required', as: 'Tanggal')]
    public $date;
    #[Validate('required', as: 'Kategori')]
    public $category;
    public $note;
    #[Validate('required', as: 'Jenis Pembayaran')]
    public $payment_method;
    public $detailOutcomes;
    #[Validate('required', as: 'Cabang')]
    public $branch_id;
    #[Validate('required', as: 'Nominal')]
    public $nominal;
    public $status;
    public $notification;
    #[Validate('required', as: 'Akun')]
    public $account_id;
    public $supplier_id;
    public $stockEntry;
    public $total_payment;
    public $references = [];
    public $outcome;
    public $uuid;

    public function mount($uuid)
    {
        $this->uuid = $uuid;
        $outcome = Outcome::with('detailOutcome','account','detailOutcome.stockEntry','supplier')->where('uuid', $uuid)->first();
        $this->outcome = $outcome;
        $this->date = $outcome->date;
        $this->account_id = $outcome->account_id;
        $this->supplier_id = $outcome->supplier_id;
        $this->nominal = number_format($outcome->nominal, 0, ',', '.');
        $this->status = $outcome->status;
        $this->category = $outcome->category;
        $this->note = $outcome->note;
        $this->payment_method = $outcome->payment_method;
        $this->branch_id = $outcome->branch_id;

        $se_id = [];
        foreach ($outcome->detailOutcome as $item) {
            $se_id[] = $item->stock_entry_id;
        }
        $this->stockEntry = StockEntry::select('stock_entries.*')
        ->selectRaw('SUM(batches.qty * CAST(batches.new_price AS INTEGER)) AS nominal')
        ->leftJoin('batches', 'stock_entries.id', '=', 'batches.stock_entry_id')
        ->groupBy('stock_entries.id')
        ->get();

        // $stockEntries = StockEntry::with('items', 'batches.item')->whereIn('id', $se_id)->get();
        // foreach ($outcome->detailOutcome as $index => $reference) {
        //     $selectedEntry = $stockEntries->firstWhere('id', $reference->stock_entry_id);
        //     if ($selectedEntry) {
        //         $this->references[$index]['id'] = rand();
        //         $this->references[$index]['stock_entry_id'] = $reference->stock_entry_id;
        //         $this->references[$index]['items'] = $selectedEntry->items->map(function($item) {
        //             $this->total_payment += $item->pivot->new_price * $item->pivot->qty;
        //             return [
        //                 'name' => $item->name,
        //                 'uom' => $item->uom,
        //                 'quantity' => $item->pivot->qty,
        //                 'purchase_price' => number_format($item->pivot->new_price, 0, ',', '.'),
        //                 'total_price' => number_format($item->pivot->new_price * $item->pivot->qty, 0, ',', '.')
        //             ];
        //         })->toArray();
        //     } else {
        //         $this->references[$index]['items'] = [];
        //     }
        // }
        // $this->nominal = $this->total_payment;
        // $this->total_payment = number_format($this->total_payment, 0, ',', '.');
    }

    #[On('detailOutcome-edit-refresh')]
    public function refresh()
    {
    }

    public function getStockEntryBySupplier($id)
    {
        $this->dispatch('setOptionStockEntry', stockentry: StockEntry::select('stock_entries.*')
        ->selectRaw('SUM(batches.qty * CAST(batches.new_price AS INTEGER)) AS nominal')
        ->leftJoin('batches', 'stock_entries.id', '=', 'batches.stock_entry_id')
        ->where('status','<>','Lunas')
        ->groupBy('stock_entries.id')
        ->where('supplier_id',$id)->get());
        $this->outcome = Outcome::with('detailOutcome','detailOutcome.account','detailOutcome.stockEntry.supplier')->where('uuid', $this->uuid)->first();
    }

    public function getItem(){;
        $this->total_payment = 0;
        $se_id = [];
        foreach ($this->references as $item) {
            $se_id[] = $item["stock_entry_id"] == '' ? null : $item["stock_entry_id"];
        }
        $stockEntries = StockEntry::with('items', 'batches.item')->whereIn('id', $se_id)->get();
        foreach ($this->references as $index => $reference) {
            $selectedEntry = $stockEntries->firstWhere('id', $reference['stock_entry_id']);
            if ($selectedEntry) {
                $this->references[$index]['items'] = $selectedEntry->items->map(function($item) {
                    $this->total_payment += $item->pivot->new_price * $item->pivot->qty;
                    return [
                        'name' => $item->name,
                        'uom' => $item->uom,
                        'quantity' => $item->pivot->qty,
                        'purchase_price' => number_format($item->pivot->new_price, 0, ',', '.'),
                        'total_price' => number_format($item->pivot->new_price * $item->pivot->qty, 0, ',', '.')
                    ];
                })->toArray();
            } else {
                $this->references[$index]['items'] = [];
            }
        }
        $this->nominal = $this->total_payment;
        $this->total_payment = number_format($this->total_payment, 0, ',', '.');
        // dd($this->references);
    }
    public function render()
    {
        return view('livewire.outcome.edit',[
            'accounts' => Account::all(),
            'suppliers' => Supplier::all(),
            'stock_entries' => $this->stockEntry,
            'branches' => Branch::where('is_active', true)->get(),
            'categories' => CategoryOutcome::all(),
            'logs' => ActivityLog::where('model_id', $this->outcome->id)->where('model', 'Outcome')->latest()->get()
        ]);
    }

    public function save()
    {
        $this->notification = null;
        $this->validate();
        $hasNull = false;

        // if ($this->category == 'Obat & Alkes' && $this->references != []) {
        //     foreach ($this->references as $r) {
        //         if ($r['stock_entry_id'] == '') {
        //             $hasNull = true;
        //         }
        //     }
        // }elseif($this->category == 'Obat & Alkes' && $this->references == []){
        //     $hasNull = true;
        // }
        // if($this->category == 'Obat & Alkes' && !$this->supplier_id){
        //     $this->notification = 'Supplier wajib diisi';
        //     return;
        // }
        // if($hasNull){
        //     $this->notification = 'Untuk Obat & Alkes wajib memilih referensi';
        //     return;
        // }

        try {
            DB::beginTransaction();
            $outcome = Outcome::find($this->outcome->id);
            $outcome->category = $this->category;
            $outcome->payment_method = $this->payment_method;
            $outcome->branch_id = $this->branch_id;
            $outcome->date = $this->date ? Carbon::parse($this->date) : NULL;
            $outcome->note = $this->note;
            $outcome->status = $this->status;
            $outcome->account_id = $this->account_id;
            $outcome->supplier_id = !$this->supplier_id || $this->supplier_id == '' ? NULL : $this->supplier_id;
            $outcome->nominal = (int)filter_var($this->nominal, FILTER_SANITIZE_NUMBER_INT);
            $outcomeDirtyAttributes = $outcome->getDirty();
            $outcome->save();

            $detail = DetailOutcome::where('outcomes_id',$outcome->id)->delete();

            // $newAttributes = collect();
            // if ($this->category == 'Obat & Alkes' && $this->references != []) {
            //     foreach($this->references as $r){
            //         $newDetail = new DetailOutcome();
            //         $newDetail->outcomes_id = $outcome->id;
            //         $newDetail->stock_entry_id = $r['stock_entry_id'] == '' ? NULL : $r['stock_entry_id'];
            //         $newDetail->save();

            //         if ($newDetail->stock_entry_id) {
            //             $se = StockEntry::find($newDetail->stock_entry_id);
            //             $nominal_se = $se->items->reduce(fn ($carry, $item) => $carry + $item['pivot']['qty'] * $item['pivot']['new_price']);
            //             $nominal_outcome = (int)filter_var($this->nominal, FILTER_SANITIZE_NUMBER_INT);
            //             $total_nominal = $nominal_outcome + (int)$newDetail->nominal;

            //             if ($nominal_se > (int)$total_nominal && (int)$total_nominal <= 0) {
            //                 $se->status = 'Hutang';
            //             } elseif ($nominal_se > (int)$total_nominal && (int)$total_nominal > 0) {
            //                 $se->status = 'Sebagian';
            //             } elseif ($nominal_se <= (int)$total_nominal) {
            //                 $se->status = 'Lunas';
            //             }
            //             $se->save();
            //         }
            //         $newAttributes->push('StockEntry Id' . ' = ' . $r['stock_entry_id']);
            //     }
            // }
            if (!empty($outcomeDirtyAttributes)) {
                // Log the changes to an audit table
                $attributeChanged = collect();
                foreach ($outcomeDirtyAttributes as $attribute => $newValue) {
                    $oldValue = $this->outcome->getOriginal($attribute); // Get the original value
                    // Log the change with attribute name, old value, and new value
                    $attributeChanged->push($attribute . ' dari ' . $oldValue . ' ke ' . $newValue);
                }
                $log = new ActivityLog();
                $log->author = auth()->user()->name;
                $log->model = 'Outcome';
                $log->model_id = $this->outcome->id;
                $log->log = 'Mengubah pengeluaran pada isian ' . $attributeChanged->join(', ');
                $log->save();
            }
            DB::commit();
            Toaster::success('Data Pengeluaran berhasil diubah');
            return $this->redirectRoute('outcome.index', navigate: true);
        } catch (\Throwable $th) {
            DB::rollback();
            Toaster::error('Gagal simpan, silakan coba beberapa saat lagi');
        }
    }
}
