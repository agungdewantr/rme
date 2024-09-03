<?php

namespace App\Livewire\Action;

use App\Models\Action;
use Livewire\Attributes\Validate;
use LivewireUI\Modal\ModalComponent;
use Masmerise\Toaster\Toaster;

class Create extends ModalComponent
{
    #[Validate('required')]
    public $name;

    #[Validate('required')]
    public $category;

    #[Validate('required|numeric')]
    public $price;

    public function render()
    {
        return view('livewire.action.create');
    }

    public function save()
    {
        $this->validate();

        $this->authorize('create', Action::class);
        try {
            $action = new Action();
            $action->name = $this->name;
            $action->category = $this->category;
            $action->price = (int)filter_var($this->price, FILTER_SANITIZE_NUMBER_INT);
            $action->save();

            Toaster::success('Tindakan berhasil dibuat');
            $this->dispatch('action-refresh');
            $this->closeModal();
        } catch (\Throwable $th) {
            Toaster::error('Gagal buat. Silakan coba beberapa saat lagi');
        }
    }
}
