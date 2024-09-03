<?php

namespace App\Livewire\Payment\Table;

use App\Models\Action;
use App\Models\DrugMedDev;
use App\Models\TmpData;
use Livewire\Component;

class CreateRow extends Component
{
    public $tmpId;
    public $iteration;
    public $total;
    public $qty;
    public $price;
    public $discount;
    public $category;
    public $type;
    public $uom;
    public $drugMedDevs;
    public $drug_action_id;
    public $actions;
    public $type_row;

    public function mount($tmpId, $iteration, $type_row)
    {
        $this->tmpId = $tmpId;
        $this->iteration = $iteration;
        $this->drugMedDevs = DrugMedDev::all();
        $this->actions = Action::select('actions.*', \DB::raw('COUNT(payment_actions.id) as payment_actions_count'))
        ->leftJoin('payment_actions', 'actions.id', '=', 'payment_actions.action_id')
        ->groupBy('actions.id')
        ->orderBy('payment_actions_count', 'desc')
        ->get();
        $this->type_row = $type_row;
    }

    public function updated()
    {
        $drug_action = 0;
        $diskon = 0;
        if ($this->drug_action_id) {
            $tmpData = TmpData::whereTempId($this->tmpId)->whereField($this->type_row . '_id')->first();
            if ($tmpData) {
                $tmpData->value = $this->drug_action_id;
                $tmpData->save();
            }
        }
        if ($this->discount != null) {
            $tmpData = TmpData::whereTempId($this->tmpId)->whereField('discount')->first();
            if ($tmpData) {
                $tmpData->value = join('', explode('.', $this->discount));
                $tmpData->save();
            }
            $diskon = (int)$this->discount;
        }
        if ($this->qty != null) {
            $tmpData = TmpData::whereTempId($this->tmpId)->whereField('qty')->first();
            if ($tmpData) {
                $tmpData->value = $this->qty;
                $tmpData->save();
            }
            if ($this->discount == null) {
                if (strpos($this->drug_action_id, '-action')) {
                    $drug_action = Action::whereId((int)filter_var($this->drug_action_id, FILTER_SANITIZE_NUMBER_INT))->first()->price * $this->qty;
                } else {
                    $drug_action = DrugMedDev::whereId((int)filter_var($this->drug_action_id, FILTER_SANITIZE_NUMBER_INT))->first()->selling_price * $this->qty;
                }
            }
        }

        $this->dispatch('grand-total-change');
    }

    public function render()
    {
        $tmpData = TmpData::whereTempId($this->tmpId)->get();
        if ($tmpData->count() && $drug_action_id = $tmpData->where('field', $this->type_row . '_id')->first()->value) {
            if (explode('-', $drug_action_id)[1] === 'drug' && $drug_action = $this->drugMedDevs->where('id', explode('-', $drug_action_id)[0])->first()) {
                $this->type = $drug_action->type;
                $this->uom = $drug_action->uom;
                $this->price = $drug_action->selling_price;
                $this->qty = $tmpData->where('field', 'qty')->first()->value;
                $this->drug_action_id = $drug_action_id;
                if ($this->qty) {
                    $this->total = $drug_action->selling_price * $this->qty - (int)filter_var($tmpData->where('field', 'discount')->first()->value, FILTER_SANITIZE_NUMBER_INT);
                }
            }
            if (explode('-', $drug_action_id)[1] === 'action' && $drug_action = $this->actions->where('id', explode('-', $drug_action_id)[0])->first()) {
                $this->category = $drug_action->category;
                $this->uom = '-';
                $this->price = $drug_action->price;
                $this->qty = $tmpData->where('field', 'qty')->first()->value;
                $this->drug_action_id = $drug_action_id;
                if ($this->qty) {
                    $this->total = $drug_action->price * $this->qty - (int)filter_var($tmpData->where('field', 'discount')->first()->value, FILTER_SANITIZE_NUMBER_INT);
                }
            }
        }
        return view('livewire.payment.table.create-row');
    }

    public function delete()
    {
        $drug_action = 0;
        if ($this->drug_action_id) {
            if (strpos($this->drug_action_id, '-action')) {
                $drug_action = Action::whereId((int)filter_var($this->drug_action_id, FILTER_SANITIZE_NUMBER_INT))->first()->price * $this->qty;
            } else {
                $drug_action = DrugMedDev::whereId((int)filter_var($this->drug_action_id, FILTER_SANITIZE_NUMBER_INT))->first()->selling_price * $this->qty;
            }
            if ($this->discount) {
                $drug_action = $drug_action - (int)$this->discount;
            }
        }
        TmpData::whereTempId($this->tmpId)->delete();
        $this->dispatch('grand-total-change');

        $this->dispatch('payment-create-table-refresh');
    }
}
