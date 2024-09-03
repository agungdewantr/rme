<?php

namespace App\Livewire\Registration;

use App\Models\Branch;
use App\Models\Registration;
use Carbon\Carbon;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    public $search;
    public $date;
    public $branch_id;

    #[On('registration-refresh')]
    public function refresh()
    {
    }

    public function render()
    {
        $this->authorize('viewAny', Registration::class);

        $registrations = Registration::with('user.patient', 'branch')
        ->where(function ($query) {
            $query->whereHas('user', function ($query) {
                    $query->where('name', 'ilike', '%' . $this->search . '%');
                })
                ->orWhereHas('user.patient', function ($query) {
                    $query->where('phone_number', 'ilike', '%' . $this->search . '%');
                });
        })
        ->when(isset($this->date[0]) && isset($this->date[1]), function ($query) {
            $query->where('date', '>=', Carbon::parse($this->date[0])->addDay()->format('Y-m-d'))
                  ->where('date', '<=', Carbon::parse($this->date[1])->addDay()->format('Y-m-d'));
        })
        ->when($this->branch_id != '', function ($query) {
            $query->where('branch_id', $this->branch_id);
        })
        ->orderBy('id', 'desc')
        ->paginate(10);

    if ($this->date || $this->search || $this->branch_id) {
        $this->resetPage();
    }

    return view('livewire.registration.index', [
        'registrations' => $registrations,
        'branches' => Branch::where('is_active', true)->get(),
    ]);
    }
}
