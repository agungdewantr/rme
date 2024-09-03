<?php

namespace App\Livewire\Payment;

use App\Models\MedicalRecord;
use App\Models\StockTransfer;
use App\Models\Transaction;
use Livewire\Component;

class Show extends Component
{
    public $transaction;
    public $stockTransfer;
    public function mount(Transaction $transaction)
    {
        $this->transaction = $transaction->load('actions', 'drugMedDevs', 'doctor', 'patient', 'medicalRecord', 'laborates','paymentMethods');
        if($this->transaction->reference_number){
            $this->stockTransfer =StockTransfer::where('stock_transfer_number', $this->transaction->reference_number)->first();
        };
    }

    public function render()
    {
        $this->authorize('view', $this->transaction);
        return view('livewire.payment.show', [
            'medicalRecords' => MedicalRecord::with('nurse', 'firstEntry', 'registration', 'registration.branch','doctor', 'usgs', 'checks', 'actions', 'drugMedDevs', 'laborate')->where('user_id', empty($this->transaction->patient_id) ? 0 : $this->transaction->patient_id)->latest()->get(),

        ]);
    }
}
