<?php

namespace App\Livewire\MedicalRecord;

use App\Models\TmpData;
use App\Models\Usg;
use App\Traits\UploadFile;
use Carbon\Carbon;
use Livewire\Attributes\Validate;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use LivewireUI\Modal\ModalComponent;
use Masmerise\Toaster\Toaster;

class UsgModalCreate extends ModalComponent
{
    use WithFileUploads, UploadFile;

    public $isEdit;
    public $medical_record_id;

    #[Validate('required', as: 'ID USG')]
    public $usg_id;

    #[Validate('required|file', as: 'File')]
    public $file;

    #[Validate('required|date', as: 'Tanggal')]
    public $date;

    public function mount($isEdit = false, $medical_record_id = 0)
    {
        $this->isEdit = $isEdit;
        if($this->isEdit){
            $last_usg = Usg::where('date', date('Y-m-d'))->orderBy('id','desc')->first();
            if ($last_usg){
                $last_usg_number = sprintf('%04d', (int)substr($last_usg->usg_id, -4)+1);
            }else{
                $last_usg_number = "0001";
            }
        }else{
            $last_usg = TmpData::whereUserId(auth()->user()->getAuthIdentifier())->whereLocation('medical-record.create')->whereField('usg_id')->orderBy('id','desc')->first();
            if($last_usg){
                $last_usg_number = sprintf('%04d', (int)substr($last_usg->value, -4)+1);
            }else{
                $last_usg_number = "0001";
            }
        }
        $this->usg_id = 'USG.'.date("y-m-d").'-'.$last_usg_number;
        $this->medical_record_id = $medical_record_id;
    }

    public function render()
    {
        return view('livewire.medical-record.usg-modal-create');
    }

    public function save()
    {
        $this->validate();

        $temp_id = rand();

        try {
            if ($this->isEdit) {
                $usg = new Usg();
                $usg->usg_id = $this->usg_id;
                $usg->date = Carbon::parse($this->date);
                $usg->file = $this->upload('usg', $this->file);
                $usg->medical_record_id = $this->medical_record_id;
                $usg->save();
                $this->dispatch('usg-table-edit-refresh');
            } else {
                $tmpData = new TmpData();
                $tmpData->field = 'usg_id';
                $tmpData->value = $this->usg_id;
                $tmpData->location = 'medical-record.create';
                $tmpData->user_id = auth()->user()->id;
                $tmpData->field_type = 'text';
                $tmpData->field_group = 'usg';
                $tmpData->temp_id = $temp_id;
                $tmpData->save();

                $tmpData = new TmpData();
                $tmpData->field = 'file';
                $tmpData->value = $this->upload('usg', $this->file);
                $tmpData->location = 'medical-record.create';
                $tmpData->user_id = auth()->user()->id;
                $tmpData->field_type = 'file';
                $tmpData->field_group = 'usg';
                $tmpData->temp_id = $temp_id;
                $tmpData->save();

                $tmpData = new TmpData();
                $tmpData->field = 'date';
                $tmpData->value = Carbon::parse($this->date);
                $tmpData->location = 'medical-record.create';
                $tmpData->user_id = auth()->user()->id;
                $tmpData->field_type = 'text';
                $tmpData->field_group = 'usg';
                $tmpData->temp_id = $temp_id;
                $tmpData->save();
                $this->dispatch('usg-table-refresh');
            }

            $this->closeModal();
        } catch (\Throwable $th) {
            dd($th);
            // Toaster::error('Gagal buat USG'. $th);
        }
    }
}
