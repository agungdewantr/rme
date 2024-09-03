<?php

namespace App\Livewire\MedicalRecord\Table\Create;

use App\Models\MedicalRecord;
use App\Models\TmpData;
use Livewire\Attributes\On;
use Livewire\Component;
use Storage;

class UsgTable extends Component
{
    public $user_id;

    public function mount($user_id)
    {
        $this->user_id = $user_id;
    }

    public function render()
    {
        return view('livewire.medical-record.table.create.usg-table', [
            'usgs' => TmpData::whereUserId(auth()->user()->getAuthIdentifier())->whereLocation('medical-record.create')->whereFieldGroup('usg')->get()->groupBy('temp_id'),
            'medicalRecord' => MedicalRecord::with('usgs')->whereUserId($this->user_id)->latest()->first() ?? (object)['usgs' => []]
        ]);
    }

    #[On('usg-table-refresh')]
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
        $this->dispatch('usg-table-refresh');
    }
}
