<?php

namespace App\Livewire\MedicalRecord\Table\Doctor;

use App\Models\Action;
use App\Models\MedicalRecordHasAction;
use Livewire\Attributes\Validate;
use LivewireUI\Modal\ModalComponent;
use Toaster;

class ActionCreate extends ModalComponent
{
    #[Validate('required|exists:actions,id', as: 'Tindakan')]
    public $action_id;

    public $medical_record_id;

    public function mount($medical_record_id)
    {
        $this->medical_record_id = $medical_record_id;
    }

    public function render()
    {
        return view('livewire.medical-record.table.doctor.action-create', [
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

        try {
            $medicalRecordHasAction = new MedicalRecordHasAction();
            $medicalRecordHasAction->action_id = $this->action_id;
            $medicalRecordHasAction->medical_record_id = $this->medical_record_id;
            $medicalRecordHasAction->total = 1;
            $medicalRecordHasAction->save();

            $this->dispatch('refresh-action-table');
            $this->closeModal();
        } catch (\Throwable $th) {
            Toaster::error('Gagal buat. Silakan coba beberapa saat lagi');
        }
    }
}
