<?php

namespace App\Livewire\FirstEntry;

use App\Models\FirstEntryHasIllnessHistory;
use App\Models\IllnessHistory;
use App\Models\PatientHasIllnessHistories;
use App\Models\TmpData;
use LivewireUI\Modal\ModalComponent;
use Livewire\Attributes\Validate;
use Masmerise\Toaster\Toaster;

class IllnessModalCreate extends ModalComponent
{

    public $isEdit;
    public $patient_id;

    #[Validate('required', as: 'Nama Penyakit Terdahulu')]
    public $illness_id;

    #[Validate('required', as: 'Terapi')]
    public $therapy;

    public function mount($isEdit = false, $patient_id = 0)
    {
        $this->isEdit = $isEdit;
        $this->patient_id = $patient_id;
    }

    public function render()
    {
        return view('livewire.first-entry.illness-modal-create',['illness' => IllnessHistory::get()]);
    }

    public function save()
    {
        $this->validate();
        $temp_id = rand();

        if (is_numeric($this->illness_id)) {
            $check_illness = IllnessHistory::find($this->illness_id);
            if (!$check_illness) {
                $check_illness = new IllnessHistory();
                $check_illness->name = $this->illness_id;
                $check_illness->save();
            }
        } else {
            $check_illness = new IllnessHistory();
            $check_illness->name = $this->illness_id;
            $check_illness->save();
        }
        $this->illness_id = $check_illness->id;

        try {
            if($this->isEdit){
                $newIllnessHistory = new PatientHasIllnessHistories();
                $newIllnessHistory->patient_id = $this->patient_id;
                $newIllnessHistory->illness_history_id = $this->illness_id;
                $newIllnessHistory->therapy = $this->therapy;
                $newIllnessHistory->save();
                $this->dispatch('illness-table-refresh');

            }else{
                $tmpData = new TmpData();
                $tmpData->field = 'illness_history_id';
                $tmpData->value = $this->illness_id;
                $tmpData->location = 'first-entry.create';
                $tmpData->user_id = auth()->user()->id;
                $tmpData->field_type = 'text';
                $tmpData->field_group = 'illness';
                $tmpData->temp_id = $temp_id;
                $tmpData->save();

                $tmpData = new TmpData();
                $tmpData->field = 'therapy';
                $tmpData->value = $this->therapy;
                $tmpData->location = 'first-entry.create';
                $tmpData->user_id = auth()->user()->id;
                $tmpData->field_type = 'text';
                $tmpData->field_group = 'illness';
                $tmpData->temp_id = $temp_id;
                $tmpData->save();
                $this->dispatch('illness-table-refresh');
            }
        $this->closeModal();
    } catch (\Throwable $th) {
        Toaster::error('Gagal buat. Silakan coba beberapa saat lagi');
    }
    }


}
