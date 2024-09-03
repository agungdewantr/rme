<?php

namespace App\Livewire\CategoryOutcome;

use App\Models\CategoryOutcome;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;
use Toaster;

class Delete extends ModalComponent
{
    public ?CategoryOutcome $categoryOutcome;
    public function mount($uuid)
    {
        $this->categoryOutcome = CategoryOutcome::where('uuid', $uuid)->first();
    }

    public function render()
    {
        return view('livewire.category-outcome.delete');
    }

    public function delete()
    {
        if (!$this->categoryOutcome) {
            Toaster::error('Kategori Pengeluaran tidak ada');
            return;
        }

        $this->categoryOutcome->delete();
        Toaster::success('Kategori Pengeluaran berhasil dihapus');
        $this->dispatch('category-refresh');
        $this->closeModal();
    }
}
