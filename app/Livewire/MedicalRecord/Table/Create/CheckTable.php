<?php

namespace App\Livewire\MedicalRecord\Table\Create;

use App\Models\MedicalRecord;
use App\Models\TmpData;
use Livewire\Attributes\On;
use Livewire\Component;
use Storage;

class CheckTable extends Component
{
    public $user_id;

    public function mount($user_id)
    {
        $this->user_id = $user_id;
    }

    public function render()
    {
        return view('livewire.medical-record.table.create.check-table', [
            'checks' => TmpData::whereUserId(auth()->user()->getAuthIdentifier())->whereLocation('medical-record.create')->whereFieldGroup('check')->get()->groupBy('temp_id'),
            'medicalRecord' => MedicalRecord::with('checks')->whereUserId($this->user_id)->latest()->first() ?? (object)['checks' => []]
        ]);
    }

    #[On('check-table-refresh')]
    public function refresh()
    {
    }

    public function delete($id)
    {
        $tmpData = TmpData::whereTempId($id)->get();
        foreach ($tmpData as $t) {
            if ($t->field_type == 'file' && Storage::exists($t->value)) {
                Storage::delete($t->value);
            }
        }
        TmpData::whereTempId($id)->delete();
        $this->dispatch('check-table-refresh');
    }
}
