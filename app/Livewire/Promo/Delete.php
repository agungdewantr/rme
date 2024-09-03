<?php

namespace App\Livewire\Promo;

use App\Models\Promo;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;
use Masmerise\Toaster\Toaster;

class Delete extends ModalComponent
{
    public ?Promo $promo;
    public function mount($uuid)
    {
        $promo = Promo::where('uuid',$uuid)->first();
        $this->promo = $promo;
    }
    public function render()
    {
        return view('livewire.promo.delete');
    }

    public function save()
    {
        try {
            $this->promo->delete();
            Toaster::success('Promo & Event berhasil dihapus');
            $this->dispatch('promo-refresh');
            $this->closeModal();
        } catch (\Throwable $th) {
            Toaster::error('Gagal hapus. Coba beberapa saat lagi');
        }
    }


}
