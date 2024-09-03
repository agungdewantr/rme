<?php

namespace App\Livewire\CategoryOutcome;

use App\Models\CategoryOutcome;
use Livewire\Attributes\Validate;
use LivewireUI\Modal\ModalComponent;
use Masmerise\Toaster\Toaster;

class Create extends ModalComponent
{
    #[Validate('required')]
    public $name;
    public $is_active = true;
    public function render()
    {
        return view('livewire.category-outcome.create');
    }

    public function save()
    {
        $this->validate();
        try {
            $poli = new CategoryOutcome();
            $poli->name = $this->name;
            $poli->is_active = $this->is_active;
            $poli->save();

            Toaster::success('Kategori Pengeluaran berhasil dibuat');
            $this->dispatch('category-refresh');
            $this->closeModal();
        } catch (\Throwable $th) {
            dd($th);
            Toaster::error('Gagal buat. Silakan coba beberapa saat lagi');
        }
    }
}

