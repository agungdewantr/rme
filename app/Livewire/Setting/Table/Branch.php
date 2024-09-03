<?php

namespace App\Livewire\Setting\Table;

use App\Models\Branch as ModelsBranch;
use Livewire\Attributes\On;
use Livewire\Component;

class Branch extends Component
{

    #[On('branch-refresh')]
    public function refresh()
    {
    }

    public function render()
    {
        return view('livewire.setting.table.branch', [
            'branches' => ModelsBranch::all()
        ]);
    }

    public function add()
    {
        $branch = new ModelsBranch();
        $branch->save();
        $this->dispatch('branch-refresh');
    }
}
