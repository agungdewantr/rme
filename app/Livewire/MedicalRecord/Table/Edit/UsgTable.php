<?php

namespace App\Livewire\MedicalRecord\Table\Edit;

use App\Models\MedicalRecord;
use App\Models\Usg;
use Livewire\Attributes\On;
use Livewire\Component;

class UsgTable extends Component
{
    public $medical_record_id;

    public function mount($medical_record_id)
    {
        $this->medical_record_id = $medical_record_id;
    }

    public function render()
    {
        return view('livewire.medical-record.table.edit.usg-table', [
            'medicalRecord' => MedicalRecord::with('usgs')->whereId($this->medical_record_id)->first()
        ]);
    }

    #[On('usg-table-edit-refresh')]
    public function refresh()
    {
    }

    public function delete($id)
    {
        Usg::where('id', $id)->delete();
        $this->dispatch('usg-table-edit-refresh');
    }
}
