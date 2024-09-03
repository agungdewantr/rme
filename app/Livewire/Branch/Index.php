<?php

namespace App\Livewire\Branch;

use App\Models\Branch;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    public function render()
    {
        return view('livewire.branch.index',[
            'branches' => Branch::paginate(10)
        ]);
    }

    #[On('branch-refresh')]
    public function refresh()
    {
    }
}
