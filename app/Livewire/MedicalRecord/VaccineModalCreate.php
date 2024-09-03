<?php

namespace App\Livewire\MedicalRecord;

use App\Models\TmpData;
use App\Models\Vaccine;
use Carbon\Carbon;
use Livewire\Attributes\Validate;
use LivewireUI\Modal\ModalComponent;
use Masmerise\Toaster\Toaster;

class VaccineModalCreate extends ModalComponent
{
    public $isEdit;
    public $user_id;

    #[Validate('required', as: 'Nama Vaksin')]
    public $name;

    #[Validate('required', as: 'Jenis/Merk Vaksin')]
    public $brand;

    #[Validate('required|date', as: 'Tanggal')]
    public $date;

    public function mount($isEdit = false, $user_id = 0)
    {
        $this->isEdit = $isEdit;
        $this->user_id = $user_id;
    }

    public function render()
    {
        return view('livewire.medical-record.vaccine-modal');
    }

    public function save()
    {
        $this->validate();

        $temp_id = rand();

        try {
            if ($this->isEdit) {
                $vaccine = new Vaccine();
                $vaccine->name = $this->name;
                $vaccine->date = Carbon::parse($this->date);
                $vaccine->brand = $this->brand;
                $vaccine->user_id = $this->user_id;
                $vaccine->save();
                $this->dispatch('vaccine-table-refresh');
            } else {
                $tmpData = new TmpData();
                $tmpData->field = 'name';
                $tmpData->value = $this->name;
                $tmpData->location = 'medical-record.create';
                $tmpData->user_id = auth()->user()->id;
                $tmpData->field_type = 'text';
                $tmpData->field_group = 'vaccine';
                $tmpData->temp_id = $temp_id;

                $tmpData->save();
                $tmpData = new TmpData();
                $tmpData->field = 'brand';
                $tmpData->value = $this->brand;
                $tmpData->location = 'medical-record.create';
                $tmpData->user_id = auth()->user()->id;
                $tmpData->field_type = 'text';
                $tmpData->field_group = 'vaccine';
                $tmpData->temp_id = $temp_id;
                $tmpData->save();

                $tmpData = new TmpData();
                $tmpData->field = 'date';
                $tmpData->value = $this->date;
                $tmpData->location = 'medical-record.create';
                $tmpData->user_id = auth()->user()->id;
                $tmpData->field_type = 'text';
                $tmpData->field_group = 'vaccine';
                $tmpData->temp_id = $temp_id;
                $tmpData->save();
                $this->dispatch('vaccine-table-refresh');
            }

            $this->closeModal();
        } catch (\Throwable $th) {
            Toaster::error('Gagal buat. Silakan coba beberapa saat lagi');
        }
    }
}
