<?php

namespace App\Livewire\Role;

use App\Models\Role;
use App\Models\User;
use Livewire\Attributes\On;
use Livewire\Component;
use Toaster;

class Edit extends Component
{
    public Role $role;
    public function mount(Role $role)
    {
        $this->role = $role;
    }

    #[On('role-refresh')]
    public function refresh()
    {
    }

    public function render()
    {
        $this->authorize('update', $this->role);
        return view('livewire.role.edit', [
            'role' => $this->role,
            'users' => User::whereRoleId($this->role->id)->paginate(10)
        ]);
    }

    public function delete($user_id)
    {
        $this->authorize('update', $this->role);
        try {
            $user = User::find($user_id);
            $user->role_id = null;
            $user->save();
            $this->dispatch('role-refresh');
        } catch (\Throwable $th) {
            Toaster::error('Tidak bisa menghapus akses user. Coba beberapa saat lagi.');
        }
    }
}
