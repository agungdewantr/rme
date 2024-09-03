<?php

namespace App\Livewire\Role\RolePermission;

use App\Models\Permission;
use App\Models\Role;
use Livewire\Component;

class EditRow extends Component
{
    public $roles;
    public $permissions = [];
    public $tmpPermissions;
    public $role_id;
    public $feature;
    public $id;

    public function mount($roles, $role, $permissionsGrouped, $feature)
    {
        $this->roles = $roles;
        $this->permissions = $permissionsGrouped->map(fn ($item) => explode('-', $item['name'])[1]);
        $this->tmpPermissions = $permissionsGrouped;
        $this->role_id = $role->name;
        $this->feature = $feature;
        $this->id = rand();
    }

    public function render()
    {
        return view('livewire.role.role-permission.edit-row');
    }

    public function saveEdit()
    {
        $permissions = collect();
        foreach ($this->permissions as $value) {
            $permission = Permission::whereName($this->feature . '-' . $value)->first();
            if (!$permission) {
                $permission = new Permission();
                $permission->name = $this->feature . '-' . $value;
                $permission->save();
            }
            $permissions->push($permission->id);
        }
        $tmpPermissions = Permission::whereIn('name', $this->tmpPermissions->pluck('name'))->get();
        $role = Role::whereName($this->role_id)->first();
        $role->permissions()->detach($tmpPermissions->pluck('id'));
        if ($permissions) {
            $role->permissions()->attach($permissions);
        }
        $this->dispatch('refresh-role');
    }

    public function delete()
    {
        $permissions = Permission::whereIn('name', collect($this->permissions)->map(fn ($item) => $this->feature . '-' . $item))->get();
        $role = Role::whereName($this->role_id)->first();
        $role->permissions()->detach($permissions->pluck('id'));
        $this->dispatch('refresh-role');
    }
}
