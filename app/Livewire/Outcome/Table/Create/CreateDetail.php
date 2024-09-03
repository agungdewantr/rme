<?php

namespace App\Livewire\Outcome\Table\Create;

use App\Models\Account;
use App\Models\ActivityLog;
use App\Models\DetailOutcome;
use App\Models\StockEntry;
use App\Models\Supplier;
use App\Models\TmpData;
use Livewire\Attributes\Validate;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;
use Masmerise\Toaster\Toaster;

class CreateDetail extends ModalComponent
{
    #[Validate('nullable', as: 'Akun')]
    public $account_id;

    #[Validate('nullable', as: 'Supplier')]
    public $supplier_id;
    #[Validate('nullable', as: 'Referensi')]
    public $stock_entry_id;
    public $note;
    public $suppliers;
    public $accounts;
    public $stock_entries;
    public $nominal;
    public $category;
    public $detailOutcome;


    public function mount($uuid,$category)
    {
        $this->detailOutcome = DetailOutcome::where('uuid', $uuid)->first();
        $this->account_id = $this->detailOutcome->account_id;
        $this->supplier_id = $this->detailOutcome->stockEntry->supplier->id ?? 0;
        $this->stock_entry_id = $this->detailOutcome->stock_entry_id;
        $this->note = $this->detailOutcome->note;
        $this->nominal = $this->detailOutcome->nominal;
        // $this->note = $category;
        // $this->category = $category;
        $this->accounts = Account::all();
        $this->suppliers = Supplier::all();
        $this->stock_entries = StockEntry::select('stock_entries.*')
        ->selectRaw('SUM(batches.qty * CAST(batches.new_price AS INTEGER)) AS nominal')
        ->leftJoin('batches', 'stock_entries.id', '=', 'batches.stock_entry_id')
        ->groupBy('stock_entries.id')
        ->get();
    }

    public function updated($property)
    {
        if($property === 'supplier_id'){
            if($this->supplier_id){
                $stock_entries = StockEntry::select('stock_entries.*')
                ->selectRaw('SUM(batches.qty * CAST(batches.new_price AS INTEGER)) AS nominal')
                ->leftJoin('batches', 'stock_entries.id', '=', 'batches.stock_entry_id')
                ->groupBy('stock_entries.id')
                ->where('supplier_id',$this->supplier_id)->get();
            }else{
                $stock_entries = StockEntry::select('stock_entries.*')
                ->selectRaw('SUM(batches.qty * CAST(batches.new_price AS INTEGER)) AS nominal')
                ->leftJoin('batches', 'stock_entries.id', '=', 'batches.stock_entry_id')
                ->groupBy('stock_entries.id')
                ->get();
            }
            $this->dispatch('refresh-stock-entry-select', references:$stock_entries);
        }
    }

    public function render()
    {
        return view('livewire.outcome.table.create.create-detail');
    }

    public function save()
    {
        if(!$this->account_id){
            Toaster::error('Akun wajib diisi');
            return;
        }

        $this->validate();

        if (is_numeric($this->account_id)) {
            $check_account = Account::find($this->account_id);
            if (!$check_account) {
                $check_account = new Account();
                $check_account->name = $this->account_id;
                $check_account->save();
            }
        } else {
            $check_account = new Account();
            $check_account->name = $this->account_id;
            $check_account->save();
        }

        $this->account_id = $check_account->id;

        try {
            $detailOutcome = $this->detailOutcome;
            $oldDetailOutcome = DetailOutcome::find($detailOutcome->id);
            $detailOutcome->account_id = $this->account_id;
            $detailOutcome->stock_entry_id = $this->stock_entry_id;
            $detailOutcome->note = $this->note;
            $detailOutcome->nominal = $this->nominal;
            $detailOutcomeDirtyAttributes = $detailOutcome->getDirty();
            $detailOutcome->save();

            if(!empty($detailOutcomeDirtyAttributes)){
                $attributeChanged = collect();
                foreach ($detailOutcomeDirtyAttributes as $attribute => $newValue) {
                    $oldValue = $oldDetailOutcome->getOriginal($attribute); // Get the original value
                    // Log the change with attribute name, old value, and new value
                    $attributeChanged->push($attribute . ' dari ' . $oldValue . ' ke ' . $newValue);
                }
                $log = new ActivityLog();
                $log->author = auth()->user()->name;
                $log->model = 'Outcome';
                $log->model_id = $detailOutcome->outcomes_id;
                $log->log = 'Mengubah detail pengeluaran dengan id '.$detailOutcome->id.' pada isian ' . $attributeChanged->join(', ');
                $log->save();
            }

            if($detailOutcome->outcome->category == 'Obat & Alkes'){
                $stock_entry = StockEntry::find($this->stock_entry_id);
                $nominal_se = $stock_entry->items->reduce(fn($carry, $item) => $carry + $item['pivot']['qty'] * $item['pivot']['new_price']);
                $nominal_outcome = DetailOutcome::where('stock_entry_id', $this->stock_entry_id)->select('nominal')->get()
                ->sum(function ($detail) {
                    return (int) $detail->nominal;
                });
                $total_nominal = $nominal_outcome + (int)$this->nominal;
                if($nominal_se > (int)$total_nominal && (int)$total_nominal <= 0){
                    $stock_entry->status = 'Hutang';
                }elseif($nominal_se > (int)$total_nominal && (int)$total_nominal > 0){
                    $stock_entry->status = 'Sebagian';
                }elseif($nominal_se <= (int)$total_nominal){
                    $stock_entry->status = 'Lunas';
                }
                $stock_entry->save();
            }
            $this->closeModal();
            Toaster::success('Detail pengeluaran berhasil diubah');
            return $this->redirectRoute('outcome.edit',$detailOutcome->outcome->uuid, navigate: true);
        } catch (\Throwable $th) {
            Toaster::error('Gagal buat. Silakan coba beberapa saat lagi');
        }
    }
}
