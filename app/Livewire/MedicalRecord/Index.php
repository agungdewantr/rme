<?php

namespace App\Livewire\MedicalRecord;

use App\Models\MedicalRecord;
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
        $this->authorize('viewAny', MedicalRecord::class);

        $medicalRecords = MedicalRecord::with('user.patient', 'registration','firstEntry')
            ->whereHas('user', function ($query) {
                $query->where('name', 'ilike', '%' . $this->search . '%');
            })
            ->when(isset($this->date[0]) && isset($this->date[1]) , function ($query) {
                $query->where('date', '>=', Carbon::parse($this->date[0])->addDay()->format('Y-m-d'))
                    ->where('date', '<=', Carbon::parse($this->date[1])->addDay()->format('Y-m-d'));
            })
            ->orderBy('id', 'desc')->paginate(10);

        if ($this->date || $this->search) {
            $this->resetPage();
        }

        return view('livewire.medical-record.index', [
            'medicalRecords' => $medicalRecords
            ,
        ]);
    }
}
