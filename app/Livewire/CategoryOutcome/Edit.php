<?php

namespace App\Livewire\CategoryOutcome;

use App\Models\CategoryOutcome;
use Livewire\Attributes\Validate;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;
use Masmerise\Toaster\Toaster;

class Edit extends ModalComponent
{
    public $category;
    #[Validate('required')]
    public $name;
    public $is_active;

    public function mount($uuid)
    {
        $category = CategoryOutcome::where('uuid',$uuid)->first();
        $this->category = $category;
        $this->name = $category->name;
        $this->is_active = $category->is_active;

    }
    public function render()
    {
        return view('livewire.category-outcome.edit');
    }


    public function save()
    {
        $this->validate();
        try {
            $this->category->name = $this->name;
            $this->category->is_active = $this->is_active;
            $this->category->save();

            Toaster::success('Kategori Pengeluaran berhasil dibuat');
            $this->dispatch('category-refresh');
            $this->closeModal();
        } catch (\Throwable $th) {
            dd($th);
            Toaster::error('Gagal buat. Silakan coba beberapa saat lagi');
        }
    }
}
