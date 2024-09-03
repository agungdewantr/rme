<tr class="text-center">
    <td>{{ $iteration }}</td>
    <td>
        <input type="text" placeholder="Nama" class="form-control" wire:model.blur="name">
    </td>
    <td>
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked" {{$is_active ? 'checked' : ''}}  wire:model.change="is_active">
          </div>
    </td>
    <td>
        <button type="button" class="btn btn-sm btn-danger" wire:click="delete">
            <i class="fa-solid fa-trash"></i>
        </button>
    </td>
</tr>
