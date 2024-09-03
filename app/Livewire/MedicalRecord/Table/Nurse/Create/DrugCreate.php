<?php

namespace App\Livewire\MedicalRecord\Table\Nurse\Create;

use App\Models\DrugMedDev;
use App\Models\TmpData;
use Livewire\Attributes\Validate;
use LivewireUI\Modal\ModalComponent;
use Toaster;

class DrugCreate extends ModalComponent
{
    #[Validate('required|exists:drug_med_devs,id', as: 'Obat/Alkes')]
    public $drug_med_dev_id;

    #[Validate('required|numeric|min:1', as: 'Jumlah')]
    public $total;

    #[Validate('required', as: 'Aturan Pakai')]
    public $rule;
    public $how_to_use;

    public function render()
    {
        return view('livewire.medical-record.table.nurse.create.drug-create', [
            'drugs' => DrugMedDev::all()
        ]);
    }

    public function save()
    {
        $this->validate();

        $drugMedDev = DrugMedDev::find($this->drug_med_dev_id);
        $temp_id = rand();
        try {
            $tmpData = new TmpData();
            $tmpData->field = 'drug_med_dev_id';
            $tmpData->value = $this->drug_med_dev_id;
            $tmpData->field_group = 'drug';
            $tmpData->field_type = 'text';
            $tmpData->location = 'medical-record.create';
            $tmpData->user_id = auth()->user()->id;
            $tmpData->temp_id = $temp_id;
            $tmpData->save();

            $tmpData = new TmpData();
            $tmpData->field = 'name';
            $tmpData->value = $drugMedDev->name;
            $tmpData->field_group = 'drug';
            $tmpData->field_type = 'text';
            $tmpData->location = 'medical-record.create';
            $tmpData->user_id = auth()->user()->id;
            $tmpData->temp_id = $temp_id;
            $tmpData->save();

            $tmpData = new TmpData();
            $tmpData->field = 'rule';
            $tmpData->value = $this->rule;
            $tmpData->field_group = 'drug';
            $tmpData->field_type = 'text';
            $tmpData->location = 'medical-record.create';
            $tmpData->user_id = auth()->user()->id;
            $tmpData->temp_id = $temp_id;
            $tmpData->save();

            $tmpData = new TmpData();
            $tmpData->field = 'how_to_use';
            $tmpData->value = $this->how_to_use;
            $tmpData->field_group = 'drug';
            $tmpData->field_type = 'text';
            $tmpData->location = 'medical-record.create';
            $tmpData->user_id = auth()->user()->id;
            $tmpData->temp_id = $temp_id;
            $tmpData->save();

            $tmpData = new TmpData();
            $tmpData->field = 'total';
            $tmpData->value = $this->total;
            $tmpData->field_group = 'drug';
            $tmpData->field_type = 'text';
            $tmpData->location = 'medical-record.create';
            $tmpData->user_id = auth()->user()->id;
            $tmpData->temp_id = $temp_id;
            $tmpData->save();

            $this->dispatch('refresh-drug-table');
            $this->closeModal();
        } catch (\Throwable $th) {
            Toaster::error('Gagal buat. Silakan coba beberapa saat lagi');
        }
    }
}
