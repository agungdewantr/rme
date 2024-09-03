<?php

namespace App\Livewire\MedicalRecord\Table\Edit;

use App\Models\Vaccine;
use Livewire\Attributes\On;
use Livewire\Component;

class VaccineTable extends Component
{
    public $user_id;

    public function mount($user_id)
    {
        $this->user_id = $user_id;
    }

    public function render()
    {
        return view('livewire.medical-record.table.edit.vaccine-table', [
            'vaccines' => Vaccine::whereUserId($this->user_id)->get()
        ]);
    }

    #[On('vaccine-table-refresh')]
    public function refresh()
    {
    }

    public function delete($id)
    {
        Vaccine::where('id', $id)->delete();
        $this->dispatch('vaccine-table-refresh');
    }
}
