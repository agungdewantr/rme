<?php

namespace App\Livewire\MedicalRecord\Table\Doctor;

use App\Models\Laborate;
use App\Models\MedicalRecord;
use App\Models\TmpData;
use Livewire\Attributes\On;
use Livewire\Component;
use Toaster;

class LaborateTable extends Component
{
    public $medical_record_id;

    public function mount($medical_record_id)
    {
        $this->medical_record_id = $medical_record_id;
    }

    #[On('refresh-laborate-table')]
    public function refesh()
    {
    }

    public function render()
    {
        return view('livewire.medical-record.table.doctor.laborate-table', [
            'laborate' => MedicalRecord::with('laborate')->where('id', $this->medical_record_id)->first()->laborate,
            'medicalRecord_id' => $this->medical_record_id
        ]);
    }

    public function delete($id)
    {
        $medicalRecord = MedicalRecord::find($this->medical_record_id);
        $medicalRecord->laborate()->detach($id);
        Toaster::success('Laborate berhasil dihapus');
        $this->dispatch('refresh-laborate-table');
    }
}
