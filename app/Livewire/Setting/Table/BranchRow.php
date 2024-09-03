<?php

namespace App\Livewire\Setting\Table;

use Livewire\Attributes\Validate;
use Livewire\Component;
use Toaster;

class BranchRow extends Component
{
    #[Validate('required')]
    public $name;

    #[Validate('nullable|boolean')]
    public $is_active = false;

    public $address;
    public $iteration;
    public $branch;

    public function mount($branch = null, $iteration)
    {
        $this->iteration = $iteration;
        $this->branch = $branch;
        if ($branch) {
            $this->name = $branch->name;
            $this->is_active = $branch->is_active;
            $this->address = $branch->address;
        }
    }

    public function render()
    {
        return view('livewire.setting.table.branch-row');
    }

    public function updated()
    {
        try {
            if ($this->branch) {
                $this->branch->name = $this->name;
                $this->branch->address = $this->address;
                $this->branch->is_active = $this->is_active;
                $this->branch->save();
            }
        } catch (\Throwable $th) {
            Toaster::error('Gagal simpan. Coba beberapa saat lagi');
        }
    }

    public function delete()
    {
        if ($this->branch->registrations()->exists()) {
            Toaster::error('Cabang masih digunakan');
            return;
        }
        $this->branch->delete();
        $this->dispatch('branch-refresh');
    }
}
