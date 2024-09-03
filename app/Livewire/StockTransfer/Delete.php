<?php

namespace App\Livewire\StockTransfer;

use App\Models\StockLedger;
use App\Models\StockTransfer;
use LivewireUI\Modal\ModalComponent;

class Delete extends ModalComponent
{
    public ?StockTransfer $stockTransfer;

    public function mount($uuid)
    {
        $this->stockTransfer = StockTransfer::where('uuid', $uuid)->first();
    }
    public function render()
    {
        return view('livewire.stock-transfer.delete', [
            'stockTransfer' => $this->stockTransfer
        ]);
    }

    public function delete()
    {
        // $stockTransferNumber = $this->stockTransfer->stock_transfer_number;

        // foreach($this->stockTransfer->batches as $b){
        //     $b->qty = $b->qty + $b->pivot->qty_used;
        //     $b->save();
        // }

        // $this->stockTransfer->delete();

        // StockLedger::where('document_reference', $stockTransferNumber)->delete();

        // $this->stockTransfer->delete();
        // $this->closeModal();
    }


}
