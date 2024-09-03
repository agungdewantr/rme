<?php

namespace App\Livewire\Laborate;

use App\Models\Laborate;
use LivewireUI\Modal\ModalComponent;
use Toaster;

class Delete extends ModalComponent
{
    public $laborate_id;

    public function mount($id)
    {
        $this->laborate_id = $id;
    }

    public function render()
    {
        return view('livewire.laborate.delete');
    }

    public function delete()
    {
        $laborate = Laborate::find($this->laborate_id);
        if ($laborate->medicalRecords()->exists()) {
            Toaster::error('Gagal hapus. Laborat masih digunakan di rekam medis');
            return;
        }
        $laborate->delete();
        $this->dispatch('laborate-refresh');
        $this->closeModal();
    }
}
