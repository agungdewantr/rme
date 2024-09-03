<?php

namespace App\Livewire\Poli;

use App\Models\Poli;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    public $search;
    public function render()
    {
        return view('livewire.poli.index',[
            'polis' => Poli::where('name', 'ilike', '%' . $this->search . '%')->orderBy('id', 'desc')->paginate(10)
        ]);
    }
    #[On('poli-refresh')]
    public function refresh()
    {
    }
}
