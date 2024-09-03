<?php

namespace App\Livewire\Laborate;

use App\Models\Laborate;
use Livewire\Attributes\Validate;
use LivewireUI\Modal\ModalComponent;
use Toaster;

class Edit extends ModalComponent
{
    public $laborate_id;
    #[Validate('required', as: 'Nama Laborat')]
    public $name;
    #[Validate('required|in:Internal,Eksternal', as: 'Tipe Laborat')]
    public $type;
    #[Validate('required|numeric', as: 'Harga Laborat')]
    public $price;

    public function mount($id)
    {
        $laborate = Laborate::find($id);
        $this->name = $laborate->name;
        $this->type = $laborate->type;
        $this->price = $laborate->price ? number_format($laborate->price, 0, ',', '.') : null;
        $this->laborate_id = $id;
    }

    public function render()
    {
        return view('livewire.laborate.edit');
    }

    public function save()
    {
        $this->validate();
        $laborate = Laborate::find($this->laborate_id);
        if (!$laborate) {
            Toaster::error('Gagal. Data tidak ditemukan');
        }
        try {
            $laborate->name = $this->name;
            $laborate->type = $this->type;
            $laborate->price = $this->price ? str_replace('.', '', $this->price) : null;
            $laborate->save();
            Toaster::success('Berhasil. Data laborat berhasil diperbarui');
            $this->dispatch('laborate-refresh');
            $this->dispatch('closeModal');
        } catch (\Throwable $th) {
            Toaster::error('Gagal. Silakan coba beberapa saat lagi');
        }
    }
}
