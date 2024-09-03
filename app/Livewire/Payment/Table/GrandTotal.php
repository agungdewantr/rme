<?php

namespace App\Livewire\Payment\Table;

use App\Models\Action;
use App\Models\DrugMedDev;
use App\Models\TmpData;
use Livewire\Attributes\On;
use Livewire\Attributes\Reactive;
use Livewire\Component;
use Symfony\Component\Console\Output\ConsoleOutput;

class GrandTotal extends Component
{
    public $total = 0;
    public $totalLaborate = 0;

    #[Reactive]
    public $laborates;

    #[Reactive]
    public $actions;

    #[Reactive]
    public $drugMedDevs;

    public function mount($total)
    {
        $this->total = $total;
        $this->dispatch('change-payment-amount', total: $this->total);
    }

    #[On('grand-total-change')]
    public function refresh($totalLaborate = 0)
    {
        $temp_total =  TmpData::whereUserId(auth()->user()->getAuthIdentifier())->whereLocation('payment.create')->get()->groupBy('temp_id');
        $total = 0;
        $this->total = 0;
        // dd($temp_total);
        foreach ($temp_total as $key => $v) {
            if ($v->where('field', 'drug_id')->first()) {
                $drug_action_id = $v->where('field', 'drug_id')->first()->value;
            } else {
                $drug_action_id = $v->where('field', 'action_id')->first()->value;
            }
            $qty =  $v->where('field', 'qty')->first()->value;
            $discount = $v->where('field', 'discount')->first()->value;
            if ($drug_action_id) {
                if (strpos($drug_action_id, '-action')) {
                    $drug_action = Action::whereId((int)filter_var($drug_action_id, FILTER_SANITIZE_NUMBER_INT))->first()->price * $qty;
                } else {
                    $drug_action = DrugMedDev::whereId((int)filter_var($drug_action_id, FILTER_SANITIZE_NUMBER_INT))->first()->selling_price * $qty;
                }
                if ($discount) {
                    $drug_action = $drug_action - (int)filter_var($discount, FILTER_SANITIZE_NUMBER_INT);
                }
                $this->total += $drug_action;
            }
        }
        if ($totalLaborate != 0) {
            $this->totalLaborate = $totalLaborate;
        }
        $this->total += $this->totalLaborate;
        $this->dispatch('change-payment-amount', total: $this->total);
    }

    public function render()
    {
        $console = new ConsoleOutput();
        // $laboratesTotal = array_reduce($this->laborates, fn ($a, $b) => $a + $b['qty'] * str_replace('.', '', $b['price']) - $b['discount'], 0);
        $console->writeln('cihuy');

        return view('livewire.payment.table.grand-total', [
            // 'laboratesTotal' => array_reduce($this->laborates ?? [], fn ($a, $b) => $a + $b['qty'] * str_replace('.', '', $b['price']) - $b['discount'], 0)
        ]);
    }
}
