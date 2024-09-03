<?php

namespace App\Livewire\FirstEntry\Table\Create;

use App\Models\IllnessHistory;
use App\Models\Patient;
use App\Models\TmpData;
use Livewire\Component;
use Livewire\Attributes\On;

class IllnessTable extends Component
{
    public $user_id;

    public function mount($user_id)
    {
        $this->user_id = $user_id;
    }
    public function render()
    {
        return view('livewire.first-entry.table.create.illness-table', [
            'illness' => TmpData::whereUserId(auth()->user()->getAuthIdentifier())->whereLocation('first-entry.create')->whereFieldGroup('illness')->get()->groupBy('temp_id'),
            'patient' => Patient::with('illnessHistories')->where('user_id', $this->user_id)->first(),
            'illness_histories' => IllnessHistory::get()
        ]);
    }

    #[On('illness-table-refresh')]
    public function refresh()
    {
    }
    public function delete($id)
    {
        TmpData::whereTempId($id)->delete();
        $this->dispatch('illness-table-refresh');
    }
}
