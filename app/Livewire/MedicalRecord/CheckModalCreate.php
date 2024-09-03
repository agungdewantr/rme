<?php

namespace App\Livewire\MedicalRecord;

use App\Models\Check;
use App\Models\TmpData;
use App\Traits\UploadFile;
use Carbon\Carbon;
use Livewire\Attributes\Validate;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use LivewireUI\Modal\ModalComponent;
use Toaster;

class CheckModalCreate extends ModalComponent
{
    use WithFileUploads, UploadFile;

    public $isEdit;
    public $medical_record_id;

    #[Validate('required', as: 'Poli Tujuan')]
    public $type;

    #[Validate('required|file', as: 'File')]
    public $file;

    #[Validate('required|date', as: 'Tanggal')]
    public $date;

    public function mount($isEdit = false, $medical_record_id = 0)
    {
        $this->isEdit = $isEdit;
        $this->medical_record_id = $medical_record_id;
    }

    public function render()
    {
        return view('livewire.medical-record.check-modal-create');
    }

    public function save()
    {
        $this->validate();

        $temp_id = rand();

        try {
            if ($this->isEdit) {
                $check = new Check();
                $check->type = $this->type;
                $check->date = Carbon::parse($this->date);
                $check->file = $this->upload('check', $this->file);
                $check->medical_record_id = $this->medical_record_id;
                $check->save();
                $this->dispatch('check-table-edit-refresh');
            } else {
                $tmpData = new TmpData();
                $tmpData->field = 'type';
                $tmpData->value = $this->type;
                $tmpData->location = 'medical-record.create';
                $tmpData->user_id = auth()->user()->id;
                $tmpData->field_type = 'text';
                $tmpData->field_group = 'check';
                $tmpData->temp_id = $temp_id;
                $tmpData->save();

                $tmpData = new TmpData();
                $tmpData->field = 'file';
                $tmpData->value = $this->upload('check', $this->file);
                $tmpData->location = 'medical-record.create';
                $tmpData->user_id = auth()->user()->id;
                $tmpData->field_type = 'file';
                $tmpData->field_group = 'check';
                $tmpData->temp_id = $temp_id;
                $tmpData->save();

                $tmpData = new TmpData();
                $tmpData->field = 'date';
                $tmpData->value = $this->date;
                $tmpData->location = 'medical-record.create';
                $tmpData->user_id = auth()->user()->id;
                $tmpData->field_type = 'text';
                $tmpData->field_group = 'check';
                $tmpData->temp_id = $temp_id;
                $tmpData->save();
                $this->dispatch('check-table-refresh');
            }

            $this->closeModal();
        } catch (\Throwable $th) {
            Toaster::error('Gagal buat Pemeriksaan');
        }
    }
}
