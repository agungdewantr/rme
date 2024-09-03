<?php

namespace App\Livewire\Payment;

use App\Models\Branch;
use App\Models\PaymentMethod;
use App\Models\Transaction;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;
use Log;

class Index extends Component
{
    use WithPagination;
    public $search;

    public $branch_id;

    public $filter_status;
    public $date;

    public function mount()
    {
        $this->branch_id = auth()->user()->branch_filter;
    }
    public function render()
    {
        $this->authorize('viewAny', Transaction::class);
        $payments = Transaction::with('patient', 'actions', 'drugMedDevs', 'laborates', 'paymentMethods')
            ->whereHas('patient', function ($query) {
                $query->where('name', 'ilike', '%' . $this->search . '%');
            })
            ->when(isset($this->date[0]) && isset($this->date[1]), function ($query) {
                $query->where('date', '>=', Carbon::parse($this->date[0])->addDay()->format('Y-m-d'))
                    ->where('date', '<=', Carbon::parse($this->date[1])->addDay()->format('Y-m-d'));
            })
            ->when($this->branch_id, function ($query) {
                $query->where('branch_id', $this->branch_id);
            })
            ->when($this->filter_status, function ($query) {
                $query->whereHas('paymentMethods', function ($query) {
                    $query->where('payment_method_id', $this->filter_status)
                        ->where('amount', '>', 0);
                });
            })
            ->orderBy('id', 'desc')
            ->paginate(10);
        if ($this->date || $this->search) {
            $this->resetPage();
        }
        return view('livewire.payment.index', [
            'payments' => $payments,
            'paymentMethods' => PaymentMethod::all(),
            'branches' => Branch::all()
        ]);
    }
}
