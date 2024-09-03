<?php

namespace App\Livewire\Setting\Table;

use Livewire\Attributes\Validate;
use Livewire\Component;
use Toaster;

class ClinicRow extends Component
{
    #[Validate('required')]
    public $name;

    #[Validate('nullable|boolean')]
    public $is_active = false;

    public $iteration;
    public $clinic;

    public function mount($clinic = null, $iteration)
    {
        $this->iteration = $iteration;
        $this->clinic = $clinic;
        if ($clinic) {
            $this->name = $clinic->name;
            $this->is_active = $clinic->is_active;
        }
    }

    public function render()
    {
        return view('livewire.setting.table.clinic-row');
    }

    public function updated()
    {
        try {
            if ($this->clinic) {
                $this->clinic->name = $this->name;
                $this->clinic->is_active = $this->is_active;
                $this->clinic->save();
            }
        } catch (\Throwable $th) {
            Toaster::error('Gagal simpan. Coba beberapa saat lagi');
        }
    }

    public function delete()
    {
        // if ($this->clinic->registrations()->exists()) {
        //     Toaster::error('Cabang masih digunakan');
        //     return;
        // }
        $this->clinic->delete();
        $this->dispatch('clinic-refresh');
    }
}
