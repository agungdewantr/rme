<?php

namespace App\Livewire\Action;

use App\Models\Action;
use LivewireUI\Modal\ModalComponent;
use Masmerise\Toaster\Toaster;

class Delete extends ModalComponent
{
    public ?Action $action;

    public function mount($uuid)
    {
        $this->action = Action::where('uuid', $uuid)->first();
    }

    public function render()
    {
        return view('livewire.action.delete');
    }

    public function delete()
    {
        if (!$this->action) {
            Toaster::error('Tindakan tidak ada');
            return;
        }

        if ($this->action->medicalRecords()->exists() || $this->action->transactions()->exists()) {
            Toaster::error('Gagal hapus. Tindakan masih digunakan di rekam medis');
            return;
        }

        $this->authorize('delete', $this->action);
        $this->action->delete();
        Toaster::success('Tindakan berhasil dihapus');
        $this->dispatch('action-refresh');
        $this->closeModal();
    }
}
