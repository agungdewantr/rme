<?php

namespace App\Livewire\FirstEntry;

use App\Models\FamilyIllnessHistory;
use App\Models\IllnessHistory;
use App\Models\Patient;
use App\Models\TmpData;
use Livewire\Attributes\Validate;
use LivewireUI\Modal\ModalComponent;
use Toaster;

class FamilyIllnessModalCreate extends ModalComponent
{
    public $isEdit;
    public $patient_id;

    #[Validate('required', as: 'Nama')]
    public $name;

    #[Validate('required', as: 'Hubungan')]
    public $relationship;

    #[Validate('required', as: 'Nama Penyakit')]
    public $disease_name;

    public function mount($isEdit = false, $patient_id = 0)
    {
        $this->isEdit = $isEdit;
        $this->patient_id = $patient_id;
    }

    public function updated($property)
    {
        if($property == 'relationship'){
            if($this->relationship == 'Suami'){
                $patient = Patient::find($this->patient_id);
                $this->name = $patient->husbands_name ?? NULL;
            }
        }
    }
    public function render()
    {
        return view('livewire.first-entry.family-illness-modal-create', [
            'illness' => IllnessHistory::all()
        ]);
    }

    public function save()
    {
        $this->validate();
        $temp_id = rand();

        if ($this->disease_name) {
            $check_illness = IllnessHistory::whereName($this->disease_name)->first();
            if (!$check_illness) {
                $check_illness = new IllnessHistory();
                $check_illness->name = $this->disease_name;
                $check_illness->save();
            }
        }
        $this->disease_name = $check_illness->name;

        try {
            if($this->isEdit){
                $familyIllnessHistori = new FamilyIllnessHistory();
                $familyIllnessHistori->name = $this->name;
                $familyIllnessHistori->relationship = $this->relationship;
                $familyIllnessHistori->disease_name = $this->disease_name;
                $familyIllnessHistori->patient_id = $this->patient_id;
                $familyIllnessHistori->save();
                $this->dispatch('family-ilness-table-refresh');
            }else{
                $tmpData = new TmpData();
                $tmpData->field = 'name';
                $tmpData->value = $this->name;
                $tmpData->location = 'first-entry.create';
                $tmpData->user_id = auth()->user()->id;
                $tmpData->field_type = 'text';
                $tmpData->field_group = 'familyillness';
                $tmpData->temp_id = $temp_id;
                $tmpData->save();

                $tmpData = new TmpData();
                $tmpData->field = 'relationship';
                $tmpData->value = $this->relationship;
                $tmpData->location = 'first-entry.create';
                $tmpData->user_id = auth()->user()->id;
                $tmpData->field_type = 'text';
                $tmpData->field_group = 'familyillness';
                $tmpData->temp_id = $temp_id;
                $tmpData->save();

                $tmpData = new TmpData();
                $tmpData->field = 'disease_name';
                $tmpData->value = $this->disease_name;
                $tmpData->location = 'first-entry.create';
                $tmpData->user_id = auth()->user()->id;
                $tmpData->field_type = 'text';
                $tmpData->field_group = 'familyillness';
                $tmpData->temp_id = $temp_id;
                $tmpData->save();
                $this->dispatch('familyillness-table-refresh');
            }

            $this->closeModal();
    } catch (\Throwable $th) {
        Toaster::error('Gagal buat. Silakan coba beberapa saat lagi');
    }
    }

}
