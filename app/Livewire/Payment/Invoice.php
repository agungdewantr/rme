<?php

namespace App\Livewire\Payment;

use App\Models\Transaction;
use Barryvdh\DomPDF\Facade\Pdf;
use Livewire\Component;

class Invoice extends Component
{
    public $transaction;

    public function mount(Transaction $transaction)
    {
        $this->transaction = $transaction;
    }


    public function render()
    {
        // return view('livewire.payment.invoice');
        // $pdf = Pdf::loadView('livewire.payment.invoice');
        // return $pdf->download('invoice.pdf');
        // return response()->s
    }
}
