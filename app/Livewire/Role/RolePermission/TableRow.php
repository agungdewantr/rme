<?php

namespace App\Livewire\Role\RolePermission;

use App\Models\Permission;
use App\Models\Role;
use App\Models\TmpData;
use Livewire\Component;
use Toaster;

class TableRow extends Component
{
    public $roles;
    public $role_id;
    public $feature;
    public $id;
    public $create;
    public $read;
    public $update;
    public $delete;
    public $import;
    public $export;
    public $print;
    public $report;

    public function mount($roles, $id)
    {
        $this->roles = $roles;
        $this->id = $id;
    }

    public function updated($property)
    {
        switch ($property) {
            case 'role_id':
                $tmpData = TmpData::where('temp_id', $this->id)->where('field', 'role')->first();
                if ($tmpData) {
                    $tmpData->value = $this->role_id;
                    $tmpData->save();
                }
                break;

            case 'feature':
                $tmpData = TmpData::where('temp_id', $this->id)->where('field', 'feature')->first();
                if ($tmpData) {
                    $tmpData->value = $this->feature;
                    $tmpData->save();
                }
                break;

            case 'create':
                $tmpData = TmpData::where('temp_id', $this->id)->where('field', 'create')->first();
                if ($tmpData) {
                    $tmpData->value = $this->create;
                    $tmpData->save();
                }
                break;

            case 'read':
                $tmpData = TmpData::where('temp_id', $this->id)->where('field', 'read')->first();
                if ($tmpData) {
                    $tmpData->value = $this->read;
                    $tmpData->save();
                }
                break;

            case 'update':
                $tmpData = TmpData::where('temp_id', $this->id)->where('field', 'update')->first();
                if ($tmpData) {
                    $tmpData->value = $this->update;
                    $tmpData->save();
                }
                break;

            case 'delete':
                $tmpData = TmpData::where('temp_id', $this->id)->where('field', 'delete')->first();
                if ($tmpData) {
                    $tmpData->value = $this->delete;
                    $tmpData->save();
                }
                break;

            case 'print':
                $tmpData = TmpData::where('temp_id', $this->id)->where('field', 'print')->first();
                if ($tmpData) {
                    $tmpData->value = $this->print;
                    $tmpData->save();
                }
                break;

            case 'report':
                $tmpData = TmpData::where('temp_id', $this->id)->where('field', 'report')->first();
                if ($tmpData) {
                    $tmpData->value = $this->report;
                    $tmpData->save();
                }
                break;

            case 'import':
                $tmpData = TmpData::where('temp_id', $this->id)->where('field', 'import')->first();
                if ($tmpData) {
                    $tmpData->value = $this->import;
                    $tmpData->save();
                }
                break;

            case 'export':
                $tmpData = TmpData::where('temp_id', $this->id)->where('field', 'export')->first();
                if ($tmpData) {
                    $tmpData->value = $this->export;
                    $tmpData->save();
                }
                break;

            default:
                # code...
                break;
        }
    }

    public function render()
    {
        return view('livewire.role.role-permission.table-row');
    }

    public function save()
    {
        if (!$this->role_id) {
            Toaster::error('Role wajib diisi');
            return;
        }
        if (!$this->feature) {
            Toaster::error('Fitur wajib diisi');
            return;
        }
        if (!$this->create && !$this->read && !$this->update && !$this->delete && !$this->import && !$this->export && !$this->print && !$this->report) {
            Toaster::error('Permission wajib diisi');
            return;
        }

        $role = Role::find($this->role_id);

        if ($this->create) {
            $permission = Permission::where('name', $this->feature . '-create')->first();
            if (!$permission) {
                $permission = new Permission();
                $permission->name = $this->feature . '-create';
                $permission->save();
            }
            $permission->roles()->attach($role->id);
        }
        if ($this->read) {
            $permission = Permission::where('name', $this->feature . '-read')->first();
            if (!$permission) {
                $permission = new Permission();
                $permission->name = $this->feature . '-read';
                $permission->save();
            }
            $permission->roles()->attach($role->id);
        }
        if ($this->delete) {
            $permission = Permission::where('name', $this->feature . '-delete')->first();
            if (!$permission) {
                $permission = new Permission();
                $permission->name = $this->feature . '-delete';
                $permission->save();
            }
            $permission->roles()->attach($role->id);
        }
        if ($this->update) {
            $permission = Permission::where('name', $this->feature . '-update')->first();
            if (!$permission) {
                $permission = new Permission();
                $permission->name = $this->feature . '-update';
                $permission->save();
            }
            $permission->roles()->attach($role->id);
        }
        if ($this->import) {
            $permission = Permission::where('name', $this->feature . '-import')->first();
            if (!$permission) {
                $permission = new Permission();
                $permission->name = $this->feature . '-import';
                $permission->save();
            }
            $permission->roles()->attach($role->id);
        }
        if ($this->export) {
            $permission = Permission::where('name', $this->feature . '-export')->first();
            if (!$permission) {
                $permission = new Permission();
                $permission->name = $this->feature . '-export';
                $permission->save();
            }
            $permission->roles()->attach($role->id);
        }
        if ($this->print) {
            $permission = Permission::where('name', $this->feature . '-print')->first();
            if (!$permission) {
                $permission = new Permission();
                $permission->name = $this->feature . '-print';
                $permission->save();
            }
            $permission->roles()->attach($role->id);
        }
        if ($this->report) {
            $permission = Permission::where('name', $this->feature . '-report')->first();
            if (!$permission) {
                $permission = new Permission();
                $permission->name = $this->feature . '-report';
                $permission->save();
            }
            $permission->roles()->attach($role->id);
        }
        TmpData::where('temp_id', $this->id)->delete();
        $this->dispatch('refresh-role');
    }

    public function deleteRow()
    {
        $this->dispatch('refresh-role');
    }
}
