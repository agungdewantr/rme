<?php

namespace App\Livewire\Action;

use App\Models\Action;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search;

    public function render()
    {
        $this->authorize('viewAny', Action::class);
        return view('livewire.action.index', [
            'actions' => Action::where('name', 'ilike', '%' . $this->search . '%')->orderBy('id', 'desc')->paginate(10)
        ]);
    }

    #[On('action-refresh')]
    public function refresh()
    {
    }
}
