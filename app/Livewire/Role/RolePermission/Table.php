<?php

namespace App\Livewire\Role\RolePermission;

use App\Models\Role;
use App\Models\TmpData;
use Livewire\Attributes\On;
use Livewire\Component;

class Table extends Component
{
    #[On('refresh-role')]
    public function refresh()
    {
    }


    public function render()
    {
        $r = Role::with('permissions')->has('permissions')->get();
        $mapped = $r->map(fn ($item) => $item->setAttribute('permissionsGrouped', $item->permissions->groupBy(function ($item) {
            return explode('-', $item['name'])[0];
        })));
        return view('livewire.role.role-permission.table', [
            'roles' => Role::all(),
            'r' => $mapped,
            'tmpRolePermissions' => TmpData::whereLocation('role')->whereUserId(auth()->user()->id)->get()->groupBy('temp_id')
        ]);
    }

    public function add()
    {
        $temp_id = rand();

        $tmp = new TmpData();
        $tmp->field = 'feature';
        $tmp->location = 'role';
        $tmp->user_id = auth()->user()->id;
        $tmp->field_type = 'text';
        $tmp->temp_id = $temp_id;
        $tmp->field_group = 'role.create';
        $tmp->save();

        $tmp = new TmpData();
        $tmp->field = 'role';
        $tmp->location = 'role';
        $tmp->user_id = auth()->user()->id;
        $tmp->field_type = 'text';
        $tmp->temp_id = $temp_id;
        $tmp->field_group = 'role.create';
        $tmp->save();

        $tmp = new TmpData();
        $tmp->field = 'create';
        $tmp->location = 'role';
        $tmp->user_id = auth()->user()->id;
        $tmp->field_type = 'text';
        $tmp->temp_id = $temp_id;
        $tmp->field_group = 'role.create';
        $tmp->save();

        $tmp = new TmpData();
        $tmp->field = 'read';
        $tmp->location = 'role';
        $tmp->user_id = auth()->user()->id;
        $tmp->field_type = 'text';
        $tmp->temp_id = $temp_id;
        $tmp->field_group = 'role.create';
        $tmp->save();

        $tmp = new TmpData();
        $tmp->field = 'update';
        $tmp->location = 'role';
        $tmp->user_id = auth()->user()->id;
        $tmp->field_type = 'text';
        $tmp->temp_id = $temp_id;
        $tmp->field_group = 'role.create';
        $tmp->save();

        $tmp = new TmpData();
        $tmp->field = 'delete';
        $tmp->location = 'role';
        $tmp->user_id = auth()->user()->id;
        $tmp->field_type = 'text';
        $tmp->temp_id = $temp_id;
        $tmp->field_group = 'role.create';
        $tmp->save();

        $tmp = new TmpData();
        $tmp->field = 'print';
        $tmp->location = 'role';
        $tmp->user_id = auth()->user()->id;
        $tmp->field_type = 'text';
        $tmp->temp_id = $temp_id;
        $tmp->field_group = 'role.create';
        $tmp->save();

        $tmp = new TmpData();
        $tmp->field = 'report';
        $tmp->location = 'role';
        $tmp->user_id = auth()->user()->id;
        $tmp->field_type = 'text';
        $tmp->temp_id = $temp_id;
        $tmp->field_group = 'role.create';
        $tmp->save();

        $tmp = new TmpData();
        $tmp->field = 'import';
        $tmp->location = 'role';
        $tmp->user_id = auth()->user()->id;
        $tmp->field_type = 'text';
        $tmp->temp_id = $temp_id;
        $tmp->field_group = 'role.create';
        $tmp->save();

        $tmp = new TmpData();
        $tmp->field = 'export';
        $tmp->location = 'role';
        $tmp->user_id = auth()->user()->id;
        $tmp->field_type = 'text';
        $tmp->temp_id = $temp_id;
        $tmp->field_group = 'role.create';
        $tmp->save();

        $this->dispatch('refresh-role');
    }
}
