<tr>
    <td>{{ $iteration }}</td>
    <td>
        <input type="text" wire:model.blur="name">
    </td>
    <td>
        <input type="checkbox" wire:model.live="is_active" class="form-check-input">
    </td>
    <td>
        <button class="btn btn-sm btn-danger" wire:click="delete" type="button">
            <i class="fa-solid fa-trash-can"></i>
        </button>
    </td>
</tr>
