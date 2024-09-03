<?php

namespace App\Livewire\Promo;

use App\Models\Promo;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    public $search;
    public function render()
    {
        return view('livewire.promo.index',[
            'promos' => Promo::where('title', 'ilike', '%' . $this->search . '%')->orderBy('id', 'desc')->paginate(10)
        ]);
    }

    #[On('promo-refresh')]
    public function refresh()
    {
    }
}
