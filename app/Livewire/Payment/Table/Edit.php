<?php

namespace App\Livewire\Payment\Table;

use App\Models\TmpData;
use Livewire\Attributes\On;
use Livewire\Component;

class Edit extends Component
{
    public $total;
    public $type;

    public function mount($total, $type)
    {
        $this->total = $total;
        $this->type = $type;
    }

    #[On('payment-create-table-refresh')]
    public function refresh()
    {
    }

    public function render()
    {
        return view('livewire.payment.table.edit', [
            'rows' => TmpData::whereLocation('payment.edit')->whereUserId(auth()->user()->id)->where('field', $this->type . "_id")->get()->groupBy('temp_id')
        ]);
    }

    public function add()
    {
        $temp_id = rand();

        $tmpData = new TmpData();
        $tmpData->field = $this->type . "_id";
        $tmpData->location = "payment.edit";
        $tmpData->user_id = auth()->user()->id;
        $tmpData->field_type = "text";
        $tmpData->field_group = "drug_action";
        $tmpData->temp_id = $temp_id;
        $tmpData->save();

        $tmpData = new TmpData();
        $tmpData->field = "qty";
        $tmpData->value = "1";
        $tmpData->location = "payment.edit";
        $tmpData->user_id = auth()->user()->id;
        $tmpData->field_type = "text";
        $tmpData->field_group = "drug_action";
        $tmpData->temp_id = $temp_id;
        $tmpData->save();

        $tmpData = new TmpData();
        $tmpData->field = "discount";
        $tmpData->location = "payment.edit";
        $tmpData->user_id = auth()->user()->id;
        $tmpData->field_type = "text";
        $tmpData->field_group = "drug_action";
        $tmpData->temp_id = $temp_id;
        $tmpData->save();

        $this->dispatch('$refresh');
    }
}
