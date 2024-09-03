<?php

namespace App\Livewire\CategoryOutcome;

use App\Models\CategoryOutcome;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    public $search;
    public function render()
    {
        return view('livewire.category-outcome.index',[
            'categories' => CategoryOutcome::where('name', 'like', '%' . $this->search . '%')->orderBy('id', 'desc')->paginate(10)
        ]);
    }

    #[On('category-refresh')]
    public function refresh()
    {
    }
}
