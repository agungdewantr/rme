<?php

namespace App\Livewire\Action;

use App\Models\Action;
use Livewire\Attributes\Validate;
use LivewireUI\Modal\ModalComponent;
use Toaster;

class Edit extends ModalComponent
{
    public ?Action $action;

    #[Validate('required')]
    public $name;

    #[Validate('required|in:Tindakan,Administrasi')]
    public $category;

    #[Validate('required|numeric')]
    public $price;

    public function mount($uuid)
    {
        $action = Action::where('uuid', $uuid)->first();
        $this->action = $action;
        $this->name = $action->name;
        $this->category = $action->category;
        $this->price =  number_format($action->price, 0, ',', '.');
    }

    public function render()
    {
        $this->authorize('update', $this->action);
        return view('livewire.action.edit');
    }

    public function save()
    {
        $this->validate();

        $this->authorize('update', $this->action);
        try {
            $this->action->name = $this->name;
            $this->action->category = $this->category;
            $this->action->price =  (int)filter_var($this->price, FILTER_SANITIZE_NUMBER_INT);
            $this->action->save();

            Toaster::success('Tindakan berhasil diubah');
            $this->dispatch('action-refresh');
            $this->closeModal();
        } catch (\Throwable $th) {
            Toaster::error('Gagal buat. Silakan coba beberapa saat lagi');
        }
    }
}
