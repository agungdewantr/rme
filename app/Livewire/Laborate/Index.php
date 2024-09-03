<?php

namespace App\Livewire\Laborate;

use App\Models\Laborate;
use Livewire\Attributes\On;
use Livewire\Component;

class Index extends Component
{
    public $search;
    public function render()
    {
        return view('livewire.laborate.index', [
            'laborates' => Laborate::where('name', 'like', '%' . $this->search . '%')->orderBy('id', 'desc')->paginate(10)
        ]);
    }

    #[On('laborate-refresh')]
    public function refresh()
    {
    }
}
