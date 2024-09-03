<?php

namespace App\Livewire\Patient;

use App\Models\Patient;
use LivewireUI\Modal\ModalComponent;
use Masmerise\Toaster\Toaster;

class DeleteModal extends ModalComponent
{
    public $uuid;

    public ?Patient $patient;

    public function mount($uuid)
    {
        $this->uuid = $uuid;
        $this->patient = Patient::where('uuid', $uuid)->first();
    }

    public function render()
    {
        return view('livewire.patient.delete-modal', [
            'uuid' => $this->uuid
        ]);
    }

    public function save()
    {
        $this->authorize('delete', $this->patient);
        if ($this->patient->transaction()->exists() || $this->patient->registration()->exists() || $this->patient->user->medicalRecords()->exists()) {
            Toaster::error('Gagal hapus. Data pasien memiliki keterkaitan dengan data lain dalam sistem');
            $this->dispatch('patient-refresh');
            $this->closeModal();
            return;
        }

        try {
            $this->patient->delete();
            Toaster::success('Data Pasien berhasil dihapus');
            $this->dispatch('patient-refresh');
            $this->closeModal();
        } catch (\Throwable $th) {
            Toaster::error('Gagal hapus. Coba beberapa saat lagi');
        }
        // if ($this->patient->medicalRecordsDoctor()->exists() || $this->healthWorker->medicalRecordsNurse()->exists()) {
        //     Toaster::error('Gagal hapus. Nakes masih digunakan di rekam medis');
        // }
    }
}
