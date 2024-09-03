<?php

namespace App\Livewire\Poli;

use App\Models\Poli;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;
use Toaster;

class Delete extends ModalComponent
{
    public ?Poli $poli;

    public function mount($uuid)
    {
        $this->poli = Poli::where('uuid', $uuid)->first();
    }

    public function render()
    {
        return view('livewire.poli.delete');
    }
    public function delete()
    {
        if (!$this->poli) {
            Toaster::error('Poli tidak ada');
            return;
        }

        if ($this->poli->branch()->exists()) {
            Toaster::error('Gagal hapus. Poli ini masih digunakan di cabang');
            return;
        }

        $this->poli->delete();
        Toaster::success('Poli berhasil dihapus');
        $this->dispatch('poli-refresh');
        $this->closeModal();
    }
}
