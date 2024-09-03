<?php

namespace App\Livewire\HealthWorker;

use App\Models\HealthWorker;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search;

    public function render()
    {
        $this->authorize('viewAny', HealthWorker::class);
        return view('livewire.health-worker.index', [
            'healthWorkers' => HealthWorker::where('name', 'ilike', '%' . $this->search . '%')->orderBy('id', 'desc')->paginate(10)
        ]);
    }

    #[On('health-worker-refresh')]
    public function refresh()
    {
    }
}
