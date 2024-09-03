<?php

namespace App\Livewire\DrugAndMedDev;

use App\Models\DrugMedDev;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search;

    #[On('drug-and-med-dev-refresh')]
    public function refresh()
    {
    }

    public function render()
    {
        $this->authorize('viewAny', DrugMedDev::class);
        return view('livewire.drug-and-med-dev.index', [
            'drugAndMedDevs' => DrugMedDev::with('category')->where('name', 'ilike', '%' . $this->search . '%')->orderBy('name', 'asc')->paginate(10)
        ]);
    }
}
