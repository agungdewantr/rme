<?php

namespace App\Livewire\StockTransfer;

use App\Models\Outcome;
use App\Models\PaymentMethod;
use App\Models\StockTransfer;
use App\Models\Transaction;
use Carbon\Carbon;
use DB;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Toaster;

class Show extends Component
{
    public $stockTransfer;
    #[Validate('required', as: 'Tanggal Klaim')]
    public $claim_date;
    #[Validate('required', as: 'Tanggal Pengeluaran')]
    public $outcome_date;

    public function mount($uuid)
    {
        // $stockTransfer = StockTransfer::where('uuid',$uuid)->first();
        // $this->stockTransfer = StockTransfer::with(['items' => function ($query)  use ($stockTransfer) {
        //     $query->with(['batches' => function ($query) use ($stockTransfer) {
        //         $query->whereIn('id', $stockTransfer->batches->pluck('id')->toArray())->first();
        //     }]);
        // }, 'toBranch', 'fromBranch'])
        // ->where('uuid', $uuid)
        // ->first();

        $this->claim_date = date('d-m-Y');
        $this->outcome_date = date('d-m-Y');

        $this->stockTransfer = StockTransfer::with(['items.batches', 'toBranch', 'fromBranch'])
            ->where('uuid', $uuid)
            ->first();


        if ($this->stockTransfer) {
            // Ambil id batch dari $this->stockTransfer untuk digunakan dalam whereIn
            $batchIds = $this->stockTransfer->batches->pluck('id')->toArray();

            // Load ulang stockTransfer dengan items dan batches yang sesuai dengan batchIds
            $this->stockTransfer->load(['items' => function ($query) use ($batchIds) {
                $query->with(['batches' => function ($query) use ($batchIds) {
                    $query->whereIn('id', $batchIds);
                }]);
            }]);
        }


        // dd($this->stockTransfer);
    }

    public function render()
    {
        return view('livewire.stock-transfer.show', [
            'stockTransfer' => $this->stockTransfer
        ]);
    }

    public function save()
    {
        $this->validate();

        try {
            DB::beginTransaction();

            // Create Transaction

            $lastTransaction = Transaction::latest()->first();

            $transaction = new Transaction();
            $currentMonth = date('m');

            if ($lastTransaction == null) {
                $transaction->transaction_number = 'INV.' . $currentMonth . '.' . '00001';
            } else {
                $lastTransactionMonth = explode('.', $lastTransaction->transaction_number)[1];

                if ($lastTransactionMonth != $currentMonth) {
                    // Reset the counter if the month has changed
                    $transaction->transaction_number = 'INV.' . $currentMonth . '.' . '00001';
                } else {
                    // Increment the counter if the month is the same
                    $lastCounter = (int) explode('.', $lastTransaction->transaction_number)[2];
                    $transaction->transaction_number = 'INV.' . $currentMonth . '.' . str_pad($lastCounter + 1, 5, "0", STR_PAD_LEFT);
                }
            }

            $transaction->date = $this->claim_date ? Carbon::parse($this->claim_date)->toDateString() : NULL;
            $transaction->medical_record_id = NULL;
            $transaction->doctor_id = NULL;
            $transaction->patient_id = 1;
            $transaction->branch_id = $this->stockTransfer->form_branch_id;
            $transaction->poli_id = NULL;
            $transaction->estimated_arrival = NULL;
            $transaction->reference_number = $this->stockTransfer->stock_transfer_number;
            $transaction->save();

            $paymentMethod = PaymentMethod::query()
                ->where('name', 'Cash')
                ->first();

            $paymentMethods[1] = [
                'amount' =>   (int)filter_var($this->stockTransfer->amount , FILTER_SANITIZE_NUMBER_INT),
            ];

            $transaction->paymentMethods()->sync($paymentMethods);

            $checkOutcome = Outcome::whereMonth('date', date('m'))->orderBy('id', 'desc')->first();
            if ($checkOutcome == null) {
                $code = 'ACC-' . date('my') . '-0001';
            } else {
                $code = 'ACC-' . date('my') . '-' . str_pad((int)explode('-', $checkOutcome->code)[2] + 1, 4, "0", STR_PAD_LEFT);
            }

            $newOutcome = new Outcome();
            $newOutcome->category = 'Obat & Alkes';
            $newOutcome->payment_method = 'Tunai';
            $newOutcome->branch_id = $this->stockTransfer->to_branch_id;
            $newOutcome->date = $this->outcome_date ? Carbon::parse($this->outcome_date) : NULL;
            $newOutcome->note = 'Pengeluaran dibuat otomatis dari sistem setelah transfer stok (' . $this->stockTransfer->stock_transfer_number . ')';
            $newOutcome->status = 'Lunas';
            $newOutcome->account_id = 3;
            $newOutcome->supplier_id = 1;
            $newOutcome->nominal =  (int)filter_var($this->stockTransfer->amount , FILTER_SANITIZE_NUMBER_INT);
            $newOutcome->code = $code;
            $newOutcome->save();

            $this->stockTransfer->isClaim = true;
            $this->stockTransfer->save();

            DB::commit();

            Toaster::success('Klaim Berhasil Dilakukan');
            return $this->redirectRoute('stock-transfer.index', navigate: true);
        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th);
            Toaster::error('Gagal simpan. Coba beberapa saat lagi.');
        }



    }

    public function unClaim()
    {
        try {
            DB::beginTransaction();
            $transaction = Transaction::where('reference_number', $this->stockTransfer->stock_transfer_number)->first();
            $outcome = Outcome::where('note','ilike','%'.$this->stockTransfer->stock_transfer_number.'%')->first();

            if($transaction){
                $transaction->delete();
            }

            if($outcome){
                $outcome->delete();
            }

            $this->stockTransfer->isClaim = false;
            $this->stockTransfer->save();
            DB::commit();
            Toaster::success('Batalkan Klaim Berhasil Dilakukan');
            return $this->redirectRoute('stock-transfer.index', navigate: true);

        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th);
            Toaster::error('Gagal simpan. Coba beberapa saat lagi.');
        }



    }
}
