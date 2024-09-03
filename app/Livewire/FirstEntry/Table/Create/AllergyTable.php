<?php

namespace App\Livewire\FirstEntry\Table\Create;

use App\Models\AllergyHistory;
use App\Models\Patient;
use App\Models\TmpData;
use Livewire\Component;
use Livewire\Attributes\On;

class AllergyTable extends Component
{
    public $user_id;

    public function mount($user_id)
    {
        $this->user_id = $user_id;
    }
    public function render()
    {
        return view('livewire.first-entry.table.create.allergy-table', [
            'allergy' => TmpData::whereUserId(auth()->user()->getAuthIdentifier())->whereLocation('first-entry.create')->whereFieldGroup('allergy')->get()->groupBy('temp_id'),
            'patient' => Patient::with('allergyHistories')->where('user_id', $this->user_id)->first(),
            'allergy_histories' => AllergyHistory::get()

        ]);
    }

    #[On('allergy-table-refresh')]
    public function refresh()
    {
    }

    public function delete($id)
    {
        TmpData::whereTempId($id)->delete();
        $this->dispatch('allergy-table-refresh');
    }
}
