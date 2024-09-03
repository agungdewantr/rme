<?php

namespace App\Livewire\MedicalRecord\Table\Doctor;

use App\Models\Batch;
use App\Models\DrugMedDev;
use App\Models\MedicalRecordHasDrugMedDev;
use App\Models\Setting;
use Livewire\Attributes\Validate;
use LivewireUI\Modal\ModalComponent;
use Toaster;

class DrugCreate extends ModalComponent
{
    #[Validate('required|exists:drug_med_devs,id', as: 'Obat/Alkes')]
    public $drug_med_dev_id;

    #[Validate('required|numeric', as: 'Jumlah')]
    public $total;

    #[Validate('required', as: 'Aturan Pakai')]
    public $rule;
    public $how_to_use;

    public $medical_record_id;

    public function mount($medical_record_id)
    {
        $this->medical_record_id = $medical_record_id;
    }

    public function render()
    {
        return view('livewire.medical-record.table.doctor.drug-create', [
            'drugs' => DrugMedDev::with(['batches' => function ($query) {
                $query->whereHas('stockEntry', function ($query) {
                    $query->where('branch_id', auth()->user()->branch_filter);
                });
            }])->orderBy('name', 'asc')->get()
        ]);
    }

    public function save()
    {
        $this->validate();

        if (Setting::whereField('is_can_minus')->first()->value == 0) {
            $qtySum = Batch::query()
                ->whereHas('stockEntry', function ($query) {
                    $query->where('branch_id', auth()->user()->branch_filter);
                })
                ->where('qty', '>', 0)
                ->where('item_id', $this->drug_med_dev_id)
                ->orderBy('expired_date', 'asc')
                ->sum('qty');
            if ($qtySum < $this->total) {
                Toaster::error('Stock Obat kurang');
                return;
            }
        }

        try {
            $medicalRecordHasDrugMedDev = new MedicalRecordHasDrugMedDev();
            $medicalRecordHasDrugMedDev->drug_med_dev_id = $this->drug_med_dev_id;
            $medicalRecordHasDrugMedDev->medical_record_id = $this->medical_record_id;
            $medicalRecordHasDrugMedDev->total = $this->total;
            $medicalRecordHasDrugMedDev->rule = $this->rule;
            $medicalRecordHasDrugMedDev->how_to_use = $this->how_to_use;
            $medicalRecordHasDrugMedDev->save();

            $this->dispatch('refresh-drug-table');
            $this->closeModal();
        } catch (\Throwable $th) {
            Toaster::error('Gagal buat. Silakan coba beberapa saat lagi');
        }
    }
}
