<?php

namespace App\Livewire\Role;

use App\Models\Role;
use App\Models\TmpData;
use Livewire\Component;

class Index extends Component
{
    public function mount()
    {
        TmpData::whereLocation('role')->whereUserId(auth()->user()->id)->delete();
    }

    public function render()
    {
        $this->authorize('viewAny', Role::class);
        return view('livewire.role.index', [
            'roles' => Role::all()
        ]);
    }
}
