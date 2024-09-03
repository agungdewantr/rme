<?php

namespace App\Livewire\DrugAndMedDev;

use App\Models\DrugMedDev;
use Livewire\Attributes\On;
use LivewireUI\Modal\ModalComponent;
use Storage;
use Toaster;

class DeleteModal extends ModalComponent
{
    public $uuid;

    public function mount($uuid)
    {
        $this->uuid = $uuid;
    }

    public function render()
    {
        return view('livewire.drug-and-med-dev.delete-modal', [
            'uuid' => $this->uuid
        ]);
    }

    public function delete()
    {
        $drugMedDev = DrugMedDev::where('uuid', $this->uuid)->first();
        $this->authorize('delete', $drugMedDev);
        if (!$drugMedDev) {
            Toaster::error('Obat atau alat kesehatan tidak ada');
            return;
        }

        if ($drugMedDev->medicalRecords()->exists() || $drugMedDev->transactions()->exists()) {
            Toaster::error('Gagal hapus. Obat atau alat kesehatan masih digunakan di rekam medis');
            return;
        }

        try {
            if ($drugMedDev->photo && Storage::exists($drugMedDev->photo)) {
                Storage::delete($drugMedDev->photo);
            }
            $drugMedDev->delete();
            Toaster::success('Obat atau alat kesehatan berhasil dihapus');
            $this->dispatch('drug-and-med-dev-refresh');
            // $this->dispatch('$refresh')->to(Index::class);
            $this->closeModal();
        } catch (\Throwable $th) {
            Toaster::error('Gagal hapus. Silakan coba beberapa saat lagi');
        }
    }
}
