<?php

namespace App\Livewire\HealthWorker;

use App\Models\HealthWorker;
use LivewireUI\Modal\ModalComponent;
use Masmerise\Toaster\Toaster;

class Delete extends ModalComponent
{
    public ?HealthWorker $healthWorker;
    public function mount($uuid)
    {
        $healthWorker = HealthWorker::where('uuid', $uuid)->first();
        $this->healthWorker = $healthWorker;
    }

    public function render()
    {
        return view('livewire.health-worker.delete');
    }

    public function save()
    {
        $this->authorize('delete', $this->healthWorker);
        if (!$this->healthWorker) {
            Toaster::error('Data Nakes tidak ada');
            return;
        }

        if ($this->healthWorker->user->medicalRecordsDoctor()->exists() || $this->healthWorker->user->medicalRecordsNurse()->exists()) {
            Toaster::error('Gagal hapus. Nakes masih digunakan di rekam medis');
            return;
        }

        try {
            $this->healthWorker->delete();
            Toaster::success('Data Tenaga Kesehatan berhasil dihapus');
            $this->dispatch('health-worker-refresh');
            $this->closeModal();
        } catch (\Throwable $th) {
            Toaster::error('Gagal hapus. Coba beberapa saat lagi');
        }
    }
}
