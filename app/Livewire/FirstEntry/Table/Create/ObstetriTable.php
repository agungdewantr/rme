<?php

namespace App\Livewire\FirstEntry\Table\Create;

use App\Models\Obstetri;
use App\Models\TmpData;
use Livewire\Attributes\On;
use Livewire\Component;

class ObstetriTable extends Component
{
    public $patient_id;

    public function mount($patient_id)
    {
        $this->patient_id = $patient_id;
    }

    #[On('obstetri-table-refresh')]
    public function refresh()
    {
    }
    public function render()
    {
        return view('livewire.first-entry.table.create.obstetri-table', [
            'rows' => TmpData::whereLocation('first-entry.create')->whereUserId(auth()->user()->id)->whereFieldGroup('obstetri')->get()->groupBy('temp_id'),
            'obstetri' => Obstetri::where('patient_id', $this->patient_id)->orderBy('id')->get()
        ]);
    }

    public function add()
    {
        $temp_id = rand();

        $tmpData = new TmpData();
        $tmpData->field = "gender";
        $tmpData->location = "first-entry.create";
        $tmpData->user_id = auth()->user()->id;
        $tmpData->field_type = "text";
        $tmpData->field_group = "obstetri";
        $tmpData->temp_id = $temp_id;
        $tmpData->save();

        $tmpData = new TmpData();
        $tmpData->field = "weight";
        $tmpData->location = "first-entry.create";
        $tmpData->user_id = auth()->user()->id;
        $tmpData->field_type = "text";
        $tmpData->field_group = "obstetri";
        $tmpData->temp_id = $temp_id;
        $tmpData->save();

        $tmpData = new TmpData();
        $tmpData->field = "type_of_birth";
        $tmpData->location = "first-entry.create";
        $tmpData->user_id = auth()->user()->id;
        $tmpData->field_type = "text";
        $tmpData->field_group = "obstetri";
        $tmpData->temp_id = $temp_id;
        $tmpData->save();

        $tmpData = new TmpData();
        $tmpData->field = "age";
        $tmpData->location = "first-entry.create";
        $tmpData->user_id = auth()->user()->id;
        $tmpData->field_type = "text";
        $tmpData->field_group = "obstetri";
        $tmpData->temp_id = $temp_id;
        $tmpData->save();

        $tmpData = new TmpData();
        $tmpData->field = "clinical_information";
        $tmpData->location = "first-entry.create";
        $tmpData->user_id = auth()->user()->id;
        $tmpData->field_type = "text";
        $tmpData->field_group = "obstetri";
        $tmpData->temp_id = $temp_id;
        $tmpData->save();
    }
}
