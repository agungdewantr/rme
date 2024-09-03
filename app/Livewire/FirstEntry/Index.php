<?php

namespace App\Livewire\FirstEntry;

use App\Models\FirstEntry;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    public $search;

    public $date;
    public function render()
    {
        $this->authorize('viewAny', FirstEntry::class);
        return view('livewire.first-entry.index', [
            'firstEntry' => FirstEntry::with(['patient' => [
                'registration' => function ($query) {
                    $query->where('date', date('Y-m-d'))->where('status', 'Administrasi');
                }
            ]])
                ->whereHas('patient', function ($query) {
                    $query->where('name', 'ilike', '%' . $this->search . '%');
                })
                ->when(isset($this->date[0]) && isset($this->date[1]), function ($query) {
                    $query->whereDate('time_stamp', '>=', Carbon::parse($this->date[0])->format('Y-m-d'))
                        ->whereDate('time_stamp', '<=', Carbon::parse($this->date[1])->format('Y-m-d'));
                })
                ->when(isset($this->date[0]) && !isset($this->date[1]), function ($query) {
                    $query->whereDate('time_stamp', '>=', Carbon::parse($this->date[0])->format('Y-m-d'))
                        ->whereDate('time_stamp', '<=', Carbon::parse($this->date[0])->format('Y-m-d'));
                })
                ->orderBy('id', 'desc')
                ->paginate(10)
        ]);
    }
}
