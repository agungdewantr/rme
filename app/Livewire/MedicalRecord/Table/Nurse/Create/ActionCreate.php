<?php

namespace App\Livewire\MedicalRecord\Table\Nurse\Create;

use App\Models\Action;
use App\Models\TmpData;
use Livewire\Attributes\Validate;
use LivewireUI\Modal\ModalComponent;
use Toaster;

class ActionCreate extends ModalComponent
{
    #[Validate('required|exists:actions,id', as: 'Tindakan')]
    public $action_id;

    public $medical_record_id;

    public function render()
    {
        return view('livewire.medical-record.table.nurse.create.action-create', [
            'actions' => Action::select('actions.*', \DB::raw('COUNT(payment_actions.id) as payment_actions_count'))
            ->leftJoin('payment_actions', 'actions.id', '=', 'payment_actions.action_id')
            ->groupBy('actions.id')
            ->orderBy('payment_actions_count', 'desc')
            ->get()
        ]);
    }

    public function save()
    {
        $this->validate();

        $action = Action::find($this->action_id);
        $temp_id = rand();
        try {
            $tmpData = new TmpData();
            $tmpData->field = 'action_id';
            $tmpData->value = $this->action_id;
            $tmpData->field_group = 'action';
            $tmpData->field_type = 'text';
            $tmpData->location = 'medical-record.create';
            $tmpData->user_id = auth()->user()->id;
            $tmpData->temp_id = $temp_id;
            $tmpData->save();

            $tmpData = new TmpData();
            $tmpData->field = 'name';
            $tmpData->value = $action->name;
            $tmpData->field_group = 'action';
            $tmpData->field_type = 'text';
            $tmpData->location = 'medical-record.create';
            $tmpData->user_id = auth()->user()->id;
            $tmpData->temp_id = $temp_id;
            $tmpData->save();

            $tmpData = new TmpData();
            $tmpData->field = 'total';
            $tmpData->value = 1;
            $tmpData->field_group = 'action';
            $tmpData->field_type = 'text';
            $tmpData->location = 'medical-record.create';
            $tmpData->user_id = auth()->user()->id;
            $tmpData->temp_id = $temp_id;
            $tmpData->save();

            $this->dispatch('refresh-action-table');
            $this->closeModal();
        } catch (\Throwable $th) {
            Toaster::error('Gagal buat. Silakan coba beberapa saat lagi');
        }
    }
}
