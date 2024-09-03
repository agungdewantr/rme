<?php

namespace App\Livewire\FirstEntry;

use App\Models\AllergyHistory;
use App\Models\FirstEntryHasAllergiesHistory;
use App\Models\PatientHasAllergyHistories;
use App\Models\TmpData;
use LivewireUI\Modal\ModalComponent;
use Livewire\Attributes\Validate;
use Masmerise\Toaster\Toaster;

class AllergyModalCreate extends ModalComponent
{

    public $isEdit;
    public $patient_id;

    #[Validate('required', as: 'Nama Alergi')]
    public $allergy_id;
    public $indication;


    public function mount($isEdit = false, $patient_id = 0)
    {
        $this->isEdit = $isEdit;
        $this->patient_id = $patient_id;
    }
    public function render()
    {
        return view('livewire.first-entry.allergy-modal-create', ['allergy' => AllergyHistory::get()]);
    }

    public function save()
    {
        $this->validate();
        $temp_id = rand();

        if (is_numeric($this->allergy_id)) {
            $check_allergy = AllergyHistory::find($this->allergy_id);
            if (!$check_allergy) {
                $check_allergy = new AllergyHistory();
                $check_allergy->name = $this->allergy_id;
                $check_allergy->save();
            }
        } else {
            $check_allergy = new AllergyHistory();
            $check_allergy->name = $this->allergy_id;
            $check_allergy->save();
        }
        $this->allergy_id = $check_allergy->id;
        try {
            if($this->isEdit){
                $newAllergyHistory = new PatientHasAllergyHistories();
                $newAllergyHistory->patient_id = $this->patient_id;
                $newAllergyHistory->allergy_history_id = $this->allergy_id;
                $newAllergyHistory->indication = $this->indication;
                $newAllergyHistory->save();
                $this->dispatch('allergy-table-refresh');
            }else{
                $tmpData = new TmpData();
                $tmpData->field = 'allergy_history_id';
                $tmpData->value = $this->allergy_id;
                $tmpData->location = 'first-entry.create';
                $tmpData->user_id = auth()->user()->id;
                $tmpData->field_type = 'text';
                $tmpData->field_group = 'allergy';
                $tmpData->temp_id = $temp_id;
                $tmpData->save();

                $tmpData = new TmpData();
                $tmpData->field = 'indication';
                $tmpData->value = $this->indication;
                $tmpData->location = 'first-entry.create';
                $tmpData->user_id = auth()->user()->id;
                $tmpData->field_type = 'text';
                $tmpData->field_group = 'allergy';
                $tmpData->temp_id = $temp_id;
                $tmpData->save();
                $this->dispatch('allergy-table-refresh');
            }
            $this->closeModal();
        } catch (\Throwable $th) {
            Toaster::error('Gagal buat. Silakan coba beberapa saat lagi');
        }
    }
}
