<?php

namespace App\Livewire\Poli;

use App\Models\CheckUp;
use App\Models\Poli;
use Livewire\Attributes\Validate;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;
use Masmerise\Toaster\Toaster;

class Create extends ModalComponent
{
    #[Validate('required')]
    public $name;
    public $is_active;
    public $checkups = [];
    public function render()
    {
        return view('livewire.poli.create');
    }

    public function save()
    {
        $this->validate();
        try {
            $poli = new Poli();
            $poli->name = $this->name;
            $poli->is_active = $this->is_active;
            $poli->save();

            foreach ($this->checkups as $c) {
                $checkup = new CheckUp();
                $checkup->poli_id = $poli->id;
                $checkup->name = $c['name'];
                $checkup->is_active = $c['status'];
                $checkup->save();
            }

            Toaster::success('Poli berhasil dibuat');
            $this->dispatch('poli-refresh');
            $this->closeModal();
        } catch (\Throwable $th) {
            dd($th);
            Toaster::error('Gagal buat. Silakan coba beberapa saat lagi');
        }
    }
}
