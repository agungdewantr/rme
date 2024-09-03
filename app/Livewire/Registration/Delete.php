<?php

namespace App\Livewire\Registration;

use App\Models\Registration;
use LivewireUI\Modal\ModalComponent;
use Masmerise\Toaster\Toaster;

class Delete extends ModalComponent
{
    public $uuid;

    public function mount($uuid)
    {
        $this->uuid = $uuid;
    }

    public function render()
    {
        return view('livewire.registration.delete');
    }

    public function save()
    {
        $registration = Registration::whereUuid($this->uuid)->first();
        $this->authorize('delete', $registration);
        if (!$registration) {
            Toaster::error('Pendaftaran tidak ada');
            return;
        }

        if($registration->medicalRecord()->exists()){
            Toaster::error('Gagal hapus. Pendaftaran ini sudah masuk di proses medical record');
            return;
        }

        try {
            $registration->delete();
            Toaster::success('Pendaftaran berhasil dihapus');
            $this->closeModal();
            $this->dispatch('registration-refresh');
        } catch (\Throwable $th) {
            Toaster::error('Gagal hapus. Silakan coba beberapa saat lagi');
        }
    }
}
