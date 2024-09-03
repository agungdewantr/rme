<?php

namespace App\Livewire\MedicalRecord\Table\Nurse\Create;

use App\Models\Laborate;
use App\Models\TmpData;
use Livewire\Attributes\Validate;
use LivewireUI\Modal\ModalComponent;
use Masmerise\Toaster\Toaster;

class LaborateCreate extends ModalComponent
{
    #[Validate('required', as: 'Nama Lab')]
    public $lab_id;
    public function render()
    {
        return view('livewire.medical-record.table.nurse.create.laborate-create', [
            'laborates' => Laborate::all()
        ]);
    }

    public function save()
    {
        $this->validate();

        $temp_id = rand();
        if (is_numeric($this->lab_id)) {
            $laborate = Laborate::find($this->lab_id);
        }
        try {
            $tmpData = new TmpData();
            $tmpData->field = 'lab_id';
            $tmpData->value = $laborate?->name ?? $this->lab_id;
            $tmpData->field_group = 'laborate';
            $tmpData->field_type = 'text';
            $tmpData->location = 'medical-record.create';
            $tmpData->user_id = auth()->user()->id;
            $tmpData->temp_id = $temp_id;
            $tmpData->save();

            $this->dispatch('refresh-laborate-table');
            $this->closeModal();
        } catch (\Throwable $th) {
            Toaster::error('Gagal buat. Silakan coba beberapa saat lagi');
        }
    }
}
