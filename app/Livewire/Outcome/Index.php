<?php

namespace App\Livewire\Outcome;

use App\Models\Branch;
use App\Models\Outcome;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    public $filter_branch;

    public function mount()
    {
        $this->filter_branch = auth()->user()->branch_filter;
    }
    public function render()
    {

        $outcomes = Outcome::with('detailOutcome','branch')
        ->when($this->filter_branch != null, function ($query) {
            $query->where('branch_id', $this->filter_branch);
        })
        ->orderBy('id','desc')->paginate(10);

        if ($this->filter_branch) {
            $this->resetPage();
        }

        return view('livewire.outcome.index',[
            'outcomes' => $outcomes,
            'branches' => Branch::all()
        ]);
    }
}
