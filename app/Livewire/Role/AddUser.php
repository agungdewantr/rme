<?php

namespace App\Livewire\Role;

use App\Models\Role;
use App\Models\User;
use Livewire\Attributes\Validate;
use LivewireUI\Modal\ModalComponent;
use Toaster;

class AddUser extends ModalComponent
{
    #[Validate('required|exists:users,id', as: 'User')]
    public $user_id;

    public $role_uuid;

    public function mount($role_uuid)
    {
        $this->role_uuid = $role_uuid;
    }

    public function render()
    {
        return view('livewire.role.add-user', [
            'users' => User::all(['id', 'name'])
        ]);
    }

    public function save()
    {
        $this->validate();
        try {
            $role = Role::whereUuid($this->role_uuid)->first();
            $user = User::find($this->user_id);
            $user->role_id = $role->id;
            $user->save();

            Toaster::success('User berhasil disimpan');
            $this->dispatch('role-refresh');
            $this->dispatch('closeModal');
        } catch (\Throwable $th) {
            Toaster::error('Gagal simpan. Coba beberapa saat lagi');
        }
    }
}
