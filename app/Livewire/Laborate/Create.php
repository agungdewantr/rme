<?php

namespace App\Livewire\Laborate;

use App\Models\Laborate;
use Livewire\Attributes\Validate;
use LivewireUI\Modal\ModalComponent;
use Toaster;

class Create extends ModalComponent
{
    #[Validate('required', as: 'Nama Laborat')]
    public $name;

    #[Validate('required|in:Internal,Eksternal', as: 'Tipe Laborat')]
    public $type;

    #[Validate('required|numeric', as: 'Harga Laborat')]
    public $price;

    public function render()
    {
        return view('livewire.laborate.create');
    }

    public function save()
    {
        $this->validate();
        try {
            $laborate = new Laborate();
            $laborate->name = $this->name;
            $laborate->type = $this->type;
            $laborate->price = $this->price;
            $laborate->save();
            Toaster::success('Data Laborat berhasil dibuat');
            $this->closeModal();
            $this->dispatch('laborate-refresh');
        } catch (\Throwable $th) {
            Toaster::error('Gagal buat. Silakan coba beberapa saat lagi');
        }
    }
}
