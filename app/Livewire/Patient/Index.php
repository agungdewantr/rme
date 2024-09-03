<?php

namespace App\Livewire\Patient;

use App\Models\Patient;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;
use Masmerise\Toaster\Toaster;

class Index extends Component
{
    use WithPagination;

    public $search;

    public function render()
    {
        $this->authorize('viewAny', Patient::class);
        $registrations = Patient::with('job')->where('name', 'ilike', '%' . $this->search . '%')->orWhere('phone_number', 'ilike', '%' . $this->search . '%')->orderBy('id', 'desc')->paginate(10);
        if ($this->search) {
            $this->resetPage();
        }
        return view('livewire.patient.index', [
            'patients' => $registrations
        ]);
    }

    #[On('patient-refresh')]
    public function refresh()
    {
    }

    #[On('delete-patient')]
    public function destroy($uuid)
    {
        $patient = Patient::with('user')->where('uuid', $uuid)->first();
        $this->authorize('delete', $patient);
        if (!$patient) {
            Toaster::error('Pasien Tidak ada');
            return;
        }

        $patient->user->delete();
        $patient->delete();

        Toaster::success('Pasien berhasil dihapus');
        $this->dispatch('$refresh');
    }
}
