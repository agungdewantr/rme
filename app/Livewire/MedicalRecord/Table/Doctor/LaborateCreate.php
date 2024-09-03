<?php

namespace App\Livewire\MedicalRecord\Table\Doctor;

use App\Models\Laborate;
use App\Models\MedicalRecord;
use App\Models\TmpData;
use Livewire\Attributes\Validate;
use LivewireUI\Modal\ModalComponent;
use Masmerise\Toaster\Toaster;

class LaborateCreate extends ModalComponent
{
    #[Validate('required', as: 'Nama Lab')]
    public $lab_id;
    public $medical_record_id;

    public function mount($medical_record_id)
    {
        $this->medical_record_id = $medical_record_id;
    }

    public function render()
    {
        return view('livewire.medical-record.table.doctor.laborate-create', [
            'laborates' => Laborate::all()
        ]);
    }

    public function save()
    {
        $this->validate();

        try {
            if (is_numeric($this->lab_id)) {
                $check_lab = Laborate::find($this->lab_id);
                if (!$check_lab) {
                    $check_lab = new Laborate();
                    $check_lab->name = $this->lab_id;
                    $check_lab->type = 'Eksternal';
                    $check_lab->save();
                }
            } else {
                $check_lab = new Laborate();
                $check_lab->name = $this->lab_id;
                $check_lab->type = 'Eksternal';
                $check_lab->save();
            }

            $medicalRecord = MedicalRecord::find($this->medical_record_id);
            $medicalRecord->laborate()->attach($check_lab->id);

            $this->dispatch('refresh-laborate-table');
            $this->closeModal();
        } catch (\Throwable $th) {
            Toaster::error('Gagal buat. Silakan coba beberapa saat lagi');
        }
    }
}
