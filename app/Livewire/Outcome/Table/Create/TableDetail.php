<?php

namespace App\Livewire\Outcome\Table\Create;

use App\Models\Account;
use App\Models\StockEntry;
use App\Models\Supplier;
use App\Models\TmpData;
use Livewire\Attributes\On;
use Livewire\Component;

class TableDetail extends Component
{
    public function mount()
    {
        TmpData::whereUserId(auth()->user()->getAuthIdentifier())->delete();
    }
    #[On('detail-outcome-table-refresh')]
    public function refresh()
    {

    }
    public function render()
    {
        return view('livewire.outcome.table.create.table-detail', [
            'detailOutcomes' => TmpData::whereUserId(auth()->user()->getAuthIdentifier())->whereLocation('outcome.create')->whereFieldGroup('detail')->get()->groupBy('temp_id'),
            'account' => Account::all(),
            'supplier' => Supplier::all(),
            'stockEntry' => StockEntry::all(),
        ]);
    }
    public function delete($id)
    {
        TmpData::whereTempId($id)->delete();
         $this->dispatch('detail-outcome-table-refresh');
    }
}
