<?php

namespace App\Livewire\Payment\Table;

use App\Models\Action;
use App\Models\DrugMedDev;
use App\Models\TmpData;
use Livewire\Attributes\On;
use Livewire\Component;

class EditGrandTotal extends Component
{
    public $total = 0;
    public $totalLaborate = 0;

    public function mount($total)
    {
        $this->total = $total;
    }

    #[On('grand-total-change')]
    public function refresh($totalLaborate = 0)
    {
        $temp_total =  TmpData::whereUserId(auth()->user()->getAuthIdentifier())->whereLocation('payment.edit')->get()->groupBy('temp_id');
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
        return view('livewire.payment.table.edit-grand-total');
    }
}
