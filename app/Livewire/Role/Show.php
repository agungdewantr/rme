<?php

namespace App\Livewire\Role;

use App\Models\Role;
use App\Models\User;
use Livewire\Component;

class Show extends Component
{
    public Role $role;
    public function mount(Role $role)
    {
        $this->role = $role;
    }

    public function render()
    {
        $this->authorize('view', $this->role);
        return view('livewire.role.show', [
            'role' => $this->role,
            'users' => User::whereRoleId($this->role->id)->paginate(10)
        ]);
    }
}
