<div class="row g-4">
    <div class="col-12">
        <table class="table">
            <thead>
                <tr>
                    <th>Fitur</th>
                    <th>Role</th>
                    <th>Permission</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($r as $r_item)
                    @foreach ($r_item->permissionsGrouped as $key => $p_item)
                        <livewire:role.role-permission.edit-row :key="rand()" :roles="$roles" :role="$r_item"
                            :permissionsGrouped="$p_item" :feature="$key" />
                    @endforeach
                @endforeach
                @foreach ($tmpRolePermissions as $key => $trp)
                    <livewire:role.role-permission.table-row :key="$key" :roles="$roles" :id="$key" />
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="col-12">
        <button class="btn btn-primary" wire:click="add">Tambah</button>
    </div>
</div>

@assets
    <style>
        table td {
            position: relative;
        }

        table td input[type=text],
        table td select {
            position: absolute;
            display: block;
            top: 0;
            left: 0;
            margin: 0;
            height: 100% !important;
            width: 100%;
            border-radius: 0 !important;
            border: none !important;
            padding: 5px;
            box-sizing: border-box;
        }

        .select2-container {
            width: 100% !important
        }
    </style>
@endassets
