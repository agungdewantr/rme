<?php

namespace App\Livewire\Branch;

use App\Models\Branch;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;
use Masmerise\Toaster\Toaster;

class Delete extends ModalComponent
{
    public ?Branch $branch;

    public function mount($uuid)
    {
        $this->branch = Branch::where('uuid',$uuid)->first();
    }
    public function render()
    {
        return view('livewire.branch.delete');
    }

    public function delete()
    {
        $this->branch->delete();
        Toaster::success('Cabang berhasil dihapus');
        $this->dispatch('branch-refresh');
        $this->closeModal();

    }
}
